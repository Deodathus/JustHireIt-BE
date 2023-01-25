<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\DTO;

final class SkillDTO
{
    public function __construct(
        public readonly string $name
    ) {}
}
