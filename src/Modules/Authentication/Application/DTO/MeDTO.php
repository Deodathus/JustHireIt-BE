<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\DTO;

final class MeDTO
{
    /**
     * @param string[] $features
     */
    public function __construct(
        public readonly string $login,
        public readonly string $email,
        public readonly string $team,
        public readonly array $features
    ) {}
}
