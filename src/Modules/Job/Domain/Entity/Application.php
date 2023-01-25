<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\ApplicationId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

class Application
{
    public function __construct(
        private readonly ApplicationId $id,
        private readonly JobPostId $jobPostId,
        private readonly ApplicantId $applicantId,
        private readonly string $introduction,
        private readonly bool $byGuest
    ) {}

    public function getId(): ApplicationId
    {
        return $this->id;
    }

    public function getApplicantId(): ApplicantId
    {
        return $this->applicantId;
    }

    public function getJobPostId(): JobPostId
    {
        return $this->jobPostId;
    }

    public function getIntroduction(): string
    {
        return $this->introduction;
    }

    public function isByGuest(): bool
    {
        return $this->byGuest;
    }
}
