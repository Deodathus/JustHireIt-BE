<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\ValueObject\JobPostId;

interface JobPostAvailabilityCheckerInterface
{
    public function check(JobPostId $id): bool;
}
