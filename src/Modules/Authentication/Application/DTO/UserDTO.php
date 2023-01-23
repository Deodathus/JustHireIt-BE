<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\DTO;

final class UserDTO
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
        public readonly string $email
    ) {}
}
