<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementId;

class JobPostRequirement
{
    public function __construct(
        private readonly JobPostId $jobPostId,
        private readonly JobPostRequirementId $requirementId
    ) {}

    public function getJobPostId(): JobPostId
    {
        return $this->jobPostId;
    }

    public function getId(): JobPostRequirementId
    {
        return $this->requirementId;
    }
}
