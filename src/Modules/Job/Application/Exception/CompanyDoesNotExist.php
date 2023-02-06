<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Exception;

final class CompanyDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "Company with given id '{$id}' does not exist!"
        );
    }

    public static function withOwnerId(string $ownerId): self
    {
        return new self(
            "Company with given owner id '{$ownerId}' does not exist!"
        );
    }
}
