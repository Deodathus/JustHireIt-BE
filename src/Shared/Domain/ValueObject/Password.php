<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final class Password
{
    public function __construct(
        public readonly string $password,
        public readonly string $salt
    ) {}
}
