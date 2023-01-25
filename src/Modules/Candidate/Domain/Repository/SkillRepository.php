<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Repository;

use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\ValueObject\SkillId;

interface SkillRepository
{
    public function store(Skill $skill): void;

    public function existsByName(string $name): bool;

    public function exists(SkillId $id): bool;

    public function fetchByName(string $name): Skill;
}
