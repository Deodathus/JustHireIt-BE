<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Exception;

final class LoginWasTakenException extends \Exception
{
    public static function withLogin(string $login): self
    {
        return new self(
            sprintf('Login "%s" was already taken!', $login)
        );
    }
}
