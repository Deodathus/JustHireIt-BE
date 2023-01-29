<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\ViewModel;

final class CandidateSkillViewModel
{
    public function __construct(
        public readonly string $skillId,
        public readonly string $candidateId,
        public readonly string $skillName,
        public readonly float $numericScore
    ) {}
}
