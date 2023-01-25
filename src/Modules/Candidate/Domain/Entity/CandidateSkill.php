<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Entity;

use App\Modules\Candidate\Domain\ValueObject\CandidateId;
use App\Modules\Candidate\Domain\ValueObject\SkillId;
use App\Modules\Candidate\Domain\ValueObject\SkillScore;

class CandidateSkill
{
    public function __construct(
        private readonly SkillId $skillId,
        private readonly CandidateId $candidateId,
        private readonly string $name,
        private readonly SkillScore $score
    ) {}

    public function getSkillId(): SkillId
    {
        return $this->skillId;
    }

    public function getCandidateId(): CandidateId
    {
        return $this->candidateId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getScore(): SkillScore
    {
        return $this->score;
    }
}
