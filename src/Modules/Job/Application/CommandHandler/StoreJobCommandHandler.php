<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Exception\UserDoesNotExist;
use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Candidate\ModuleApi\Application\Query\SkillByIdExistsQuery;
use App\Modules\Job\Application\Command\StoreJobCommand;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Application\Exception\JobCategoryDoesNotExist;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use App\Modules\Job\Application\Exception\JobPostRequirementDoesNotExist;
use App\Modules\Job\Domain\Entity\Job;
use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Entity\JobPostProperty;
use App\Modules\Job\Domain\Entity\JobPostRequirement;
use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Modules\Job\Domain\Repository\JobCategoryRepository;
use App\Modules\Job\Domain\Service\JobPersisterInterface;
use App\Modules\Job\Domain\ValueObject\JobCategoryId;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostPropertyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;

final class StoreJobCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly JobPersisterInterface $persister,
        private readonly JobCategoryRepository $jobCategoryRepository
    ) {}

    public function __invoke(StoreJobCommand $storeJobCommand): string
    {
        try {
            $ownerId = $this->queryBus->handle(
                new GetUserIdByTokenQuery($storeJobCommand->job->ownerToken)
            );
        } catch (UserDoesNotExist $exception) {
            throw JobOwnerDoesNotExist::withId($storeJobCommand->job->ownerToken);
        }

        if (!$this->jobCategoryRepository->exists(JobCategoryId::fromString($storeJobCommand->job->categoryId))) {
            throw JobCategoryDoesNotExist::withId($storeJobCommand->job->categoryId);
        }

        $id = JobId::generate();

        $job = Job::create(
            $id,
            OwnerId::fromString($ownerId),
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
            $jobPostId = JobPostId::generate();

            $posts[] = JobPost::create(
                $jobPostId,
                $id,
                $jobPost->name,
                $this->prepareJobPostProperties($jobPostId, $jobPost),
                $this->prepareJobPostRequirements($jobPostId, $jobPost)
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

    /**
     * @return JobPostRequirement[]
     */
    private function prepareJobPostRequirements(JobPostId $jobPostId, JobPostDTO $jobPost): array
    {
        $requirements = [];

        foreach ($jobPost->requirements as $requirement) {
            $requirementExists = $this->queryBus->handle(new SkillByIdExistsQuery($requirement->id));
            if (!$requirementExists) {
                throw JobPostRequirementDoesNotExist::withId($requirement->id);
            }

            $requirements[] = new JobPostRequirement(
                $jobPostId,
                JobPostRequirementId::fromString($requirement->id)
            );
        }

        return $requirements;
    }
}
