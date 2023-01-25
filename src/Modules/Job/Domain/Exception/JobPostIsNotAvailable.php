<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Exception;

final class JobPostIsNotAvailable extends \Exception
{
    public static function withId(string $id, \Throwable $previous = null): self
    {
        return new self(
            "Job post with id '{$id}' is not available!",
            0,
            $previous
        );
    }
}
