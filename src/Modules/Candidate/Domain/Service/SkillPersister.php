<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Service;

use App\Modules\Candidate\Domain\Entity\Skill;

interface SkillPersister
{
    public function store(Skill $skill): void;
}
