<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobPostDoesNotBelongToJob extends \Exception
{
    public static function withIds(string $jobId, string $jobPostId): self
    {
        return new self(
            "Given job post with id '{$jobPostId}' does not belong to job with id '{$jobId}'"
        );
    }
}
