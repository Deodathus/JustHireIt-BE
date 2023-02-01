<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobPostDoesNotExist extends \Exception
{
    public static function withId(string $id, ?\Throwable $previous = null): self
    {
        return new self(
            "Job post with given id '{$id}' does not exist!",
            0,
            $previous
        );
    }

    public static function withIdAndJobId(string $id, string $jobId, ?\Throwable $previous = null): self
    {
        return new self(
            "Job post with given id '{$id}' does not belong to job with id '{$jobId}' or does not exist!",
            0,
            $previous
        );
    }
}
