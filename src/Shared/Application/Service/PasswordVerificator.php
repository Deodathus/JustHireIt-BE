<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

final class PasswordVerificator implements PasswordVerificatorInterface
{
    public function verify(string $hashedPassword, string $rawPassword, string $salt): bool
    {
        return password_verify($rawPassword . $salt, $hashedPassword);
    }
}
