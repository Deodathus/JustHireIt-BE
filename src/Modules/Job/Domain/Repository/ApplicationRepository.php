<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\ValueObject\ApplicantId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

interface ApplicationRepository
{
    public function store(Application $application): void;

    public function applicantAppliedOnJobPost(ApplicantId $applicantId, JobPostId $jobPostId): bool;
}
