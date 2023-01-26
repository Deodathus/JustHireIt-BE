<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\Exception;

final class LoginIsAlreadyTaken extends \Exception
{
    public static function withLogin(string $login, ?\Throwable $previous = null): self
    {
        return new self(
            "Login '{$login}' is already taken!",
            0,
            $previous
        );
    }
}
