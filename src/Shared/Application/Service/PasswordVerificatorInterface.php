<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

interface PasswordVerificatorInterface
{
    public function verify(string $hashedPassword, string $rawPassword, string $salt): bool;
}
