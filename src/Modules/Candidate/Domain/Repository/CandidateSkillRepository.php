<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Repository;

use App\Modules\Candidate\Domain\Entity\CandidateSkill;

interface CandidateSkillRepository
{
    public function store(CandidateSkill $skill): void;
}
