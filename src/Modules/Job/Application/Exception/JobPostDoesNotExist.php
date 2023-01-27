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
}
