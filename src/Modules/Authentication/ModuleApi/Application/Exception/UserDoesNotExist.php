<?php

declare(strict_types=1);

namespace App\Modules\Authentication\ModuleApi\Application\Exception;

final class UserDoesNotExist extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            "User with given id '{$id}' does not exist!"
        );
    }

    public static function withToken(string $token): self
    {
        return new self(
            "User with given token '{$token}' does not exist!"
        );
    }
}
