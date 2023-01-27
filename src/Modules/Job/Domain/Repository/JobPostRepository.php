<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\JobPost;
use App\Modules\Job\Domain\ValueObject\JobId;
use App\Modules\Job\Domain\ValueObject\JobPostId;

interface JobPostRepository
{
    public function store(JobPost $jobPost): void;

    public function fetch(JobPostId $id): JobPost;

    public function close(JobPost $jobPost): void;

    public function jobPostBelongsToJob(JobId $jobId, JobPostId $jobPostId): bool;

    /**
     * @return JobPost[]
     */
    public function fetchNotClosedByJobId(JobId $jobId): array;
}
