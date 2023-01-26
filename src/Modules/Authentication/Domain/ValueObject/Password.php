<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\ValueObject;

final class Password
{
    public function __construct(
        public readonly string $password,
        public readonly string $salt
    ) {}
}
