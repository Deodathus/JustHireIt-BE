<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\DTO;

final class ClientDTO
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
        public readonly string $email
    ) {}
}
