<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Factory;

use App\Modules\Candidate\ModuleApi\Application\Query\SkillByIdExistsQuery;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Application\Exception\JobPostRequirementDoesNotExist;
use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\Entity\JobPostProperty;
use App\Modules\Job\Domain\Entity\JobPostRequirement;
use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostPropertyId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementId;
use App\Shared\Application\Messenger\QueryBus;

final class JobPostFactory
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function build(JobId $jobId, JobPostDTO $jobPost): JobPost
    {
        $jobPostId = JobPostId::generate();

        return JobPost::create(
            $jobPostId,
            $jobId,
            $jobPost->name,
            $this->prepareJobPostProperties($jobPostId, $jobPost),
            $this->prepareJobPostRequirements($jobPostId, $jobPost)
        );
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
