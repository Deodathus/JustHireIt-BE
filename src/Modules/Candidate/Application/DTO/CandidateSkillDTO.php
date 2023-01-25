<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\DTO;

final class CandidateSkillDTO
{
    public function __construct(
        public readonly string $skillId,
        public readonly string $name,
        public readonly string $score,
        public readonly float $numericScore
    ) {}
}
