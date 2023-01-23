<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Job\Application\Command\StoreJobCommand;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Entity\JobPostProperty;
use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Modules\Job\Domain\Service\JobPersisterInterface;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostPropertyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;

final class StoreJobCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly JobPersisterInterface $persister
    ) {}

    public function __invoke(StoreJobCommand $storeJobCommand): string
    {
        $ownerId = $this->queryBus->handle(
            new GetUserIdByTokenQuery($storeJobCommand->job->ownerToken)
        );

        $id = JobId::generate();

        $job = new Job(
            $id,
            OwnerId::fromString($ownerId),
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
            $jobPostId = JobPostId::generate();

            $posts[] = new JobPost(
                $jobPostId,
                $id,
                $jobPost->name,
                $this->prepareJobPostProperties($jobPostId, $jobPost),
                []
            );
        }

        return $posts;
    }

    /**
     * @return JobPostProperty[]
     */
    private function prepareJobPostProperties(JobPostId $jobPostId, JobPostDTO $jobPost): array
    {
        $properties = [];

        foreach ($jobPost->properties as $property) {
            $properties[] = new JobPostProperty(
                JobPostPropertyId::generate(),
                $jobPostId,
                JobPostPropertyTypes::tryFrom($property->type),
                $property->value
            );
        }

        return $properties;
    }
}
