<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\ValueObject;

final class JobPostRequirementScore
{
    public function __construct(
        private readonly int $score
    ) {}

    public function getScore(): int
    {
        return $this->score;
    }
}
