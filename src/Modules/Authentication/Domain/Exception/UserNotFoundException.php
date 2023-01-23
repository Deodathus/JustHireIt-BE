<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Exception;

final class UserNotFoundException extends \Exception
{
    public static function withId(string $id): self
    {
        return new self(
            sprintf('User with id "%s" does not exist!', $id)
        );
    }

    public static function withToken(string $token): self
    {
        return new self(
            sprintf('User with token "%s" does not exist!', $token)
        );
    }
}
