<?php

declare(strict_types=1);

namespace App\Modules\Billing\ModuleApi\Application\DTO;

final class Team
{
    /**
     * @param string $name
     * @param string[] $features
     */
    public function __construct(
        public readonly string $name,
        public readonly array $features
    ) {}
}
