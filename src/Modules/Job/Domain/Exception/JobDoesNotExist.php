<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Exception;

final class JobDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Job with given id '{$id}' does not exist!"
        );
    }
}
