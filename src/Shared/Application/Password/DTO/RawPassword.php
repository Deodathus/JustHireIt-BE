<?php

declare(strict_types=1);

namespace App\Shared\Application\Password\DTO;

final class RawPassword
{
    public function __construct(
        public readonly string $password
    ) {}
}
