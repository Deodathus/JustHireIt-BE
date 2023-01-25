<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\ValueObject;

final class SkillScore
{
    public function __construct(
        private readonly string $score,
        private readonly float $numericScore
    ) {}

    public function getScore(): string
    {
        return $this->score;
    }

    public function getNumericScore(): float
    {
        return $this->numericScore;
    }
}
