<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\DTO;

final class RawPassword
{
    public function __construct(
        public readonly string $password
    ) {}
}
