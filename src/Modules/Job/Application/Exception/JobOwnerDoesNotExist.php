<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class JobOwnerDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Owner with id '{$id}' does not exist!"
        );
    }
}
