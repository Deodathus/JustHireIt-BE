<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobNotFound extends \Exception
{
    public static function withId(string $id, ?\Throwable $previous = null): self
    {
        return new self(
            "Job with given id '{$id}' not found!",
            0,
            $previous
        );
    }
}
