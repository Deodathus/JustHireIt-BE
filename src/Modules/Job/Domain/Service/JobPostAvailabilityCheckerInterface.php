<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

interface JobPostAvailabilityCheckerInterface
{
    public function check(ApplicantId $applicantId, JobPostId $jobPostId): bool;
}
