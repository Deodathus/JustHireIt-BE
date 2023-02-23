<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamByMember;
use App\Modules\Job\Application\Command\StoreJobCommand;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\Exception\JobCategoryDoesNotExist;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use App\Modules\Job\Application\Factory\JobPostFactory;
use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Repository\JobCategoryRepository;
use App\Modules\Job\Domain\Service\JobPersisterInterface;
use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use App\Modules\Job\Infrastructure\Repository\CompanyRepository;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;

final class StoreJobCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly JobPersisterInterface $persister,
        private readonly JobCategoryRepository $jobCategoryRepository,
        private readonly JobPostFactory $jobPostFactory,
        private readonly CompanyRepository $companyRepository
    ) {}

    public function __invoke(StoreJobCommand $storeJobCommand): string
    {
        try {
            $ownerId = $this->queryBus->handle(
                new GetTeamByMember(
                    $this->queryBus->handle(
                        new GetUserIdByTokenQuery($storeJobCommand->job->ownerToken)
                    )
                )
            )->id;
        } catch (UserDoesNotExist $exception) {
            throw JobOwnerDoesNotExist::withId($storeJobCommand->job->ownerToken);
        }

        if (!$this->jobCategoryRepository->exists(JobCategoryId::fromString($storeJobCommand->job->categoryId))) {
            throw JobCategoryDoesNotExist::withId($storeJobCommand->job->categoryId);
        }

        $id = JobId::generate();

        $job = Job::create(
            $id,
            $this->companyRepository->fetchCompanyIdByOwner(OwnerId::fromString($ownerId)),
            JobCategoryId::fromString($storeJobCommand->job->categoryId),
            $storeJobCommand->job->name,
            $this->prepareJobPosts($id, $storeJobCommand->job)
        );

        $this->persister->store($job);

        return $id->toString();
    }

    /**
     * @return JobPost[]
     */
    private function prepareJobPosts(JobId $id, JobDTO $job): array
    {
        $posts = [];

        foreach ($job->jobPosts as $jobPost) {
            $posts[] = $this->jobPostFactory->build($id, $jobPost);
        }

        return $posts;
    }
}
