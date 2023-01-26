<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\DTO;

final class HashedPassword
{
    public function __construct(
        public readonly string $password,
        public readonly string $salt
    ) {}
}
