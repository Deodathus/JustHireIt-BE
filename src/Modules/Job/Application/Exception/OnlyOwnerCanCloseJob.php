<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class OnlyOwnerCanCloseJob extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Closer with id '{$id}' does not belong to owner!"
        );
    }
}
