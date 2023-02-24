<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Modules\Job\Domain\Service\JobPostAvailabilityCheckerInterface;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

final class JobPostAvailabilityCheckerSpy implements JobPostAvailabilityCheckerInterface
{
    private ?\Throwable $reason = null;

    public function __construct(
        private bool $jobPostIsAvailable = true
    ) {}

    public function check(ApplicantId $applicantId, JobPostId $jobPostId): bool
    {
        if ($this->reason) {
            throw $this->reason;
        }

        return $this->jobPostIsAvailable;
    }

    public function makeNotAvailable(\Throwable $reason): void
    {
        $this->reason = $reason;
        $this->jobPostIsAvailable = false;
    }

    public function makeAvailable(): void
    {
        $this->jobPostIsAvailable = true;
    }
}
