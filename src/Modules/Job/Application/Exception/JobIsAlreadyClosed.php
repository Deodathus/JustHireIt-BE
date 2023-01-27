<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobIsAlreadyClosed extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Job with id '{$id}' is already closed!"
        );
    }
}
