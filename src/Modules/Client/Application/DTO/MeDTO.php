<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\DTO;

final class MeDTO
{
    /**
     * @param string[] $permissions
     */
    public function __construct(
        public readonly string $login,
        public readonly string $email,
        public readonly string $groupName,
        public readonly array $permissions
    ) {}
}
