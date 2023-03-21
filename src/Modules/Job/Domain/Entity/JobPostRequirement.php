<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementId;
use App\Modules\Job\Domain\ValueObject\JobPostRequirementScore;

class JobPostRequirement
{
    public function __construct(
        private readonly JobPostId $jobPostId,
        private readonly JobPostRequirementId $requirementId,
        private readonly JobPostRequirementScore $score
    ) {}

    public function getJobPostId(): JobPostId
    {
        return $this->jobPostId;
    }

    public function getId(): JobPostRequirementId
    {
        return $this->requirementId;
    }

    public function getScore(): JobPostRequirementScore
    {
        return $this->score;
    }
}
