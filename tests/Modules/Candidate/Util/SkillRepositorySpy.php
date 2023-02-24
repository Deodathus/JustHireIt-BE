<?php

declare(strict_types=1);

namespace App\Tests\Modules\Candidate\Util;

use App\Modules\Candidate\Application\Exception\SkillDoesNotExist;
use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\Repository\SkillRepository;
use App\Modules\Candidate\Domain\ValueObject\SkillId;

final class SkillRepositorySpy implements SkillRepository
{
    /** @var Skill[] $stored */
    private array $stored = [];

    public function store(Skill $skill): void
    {
        $this->stored[] = $skill;
    }

    public function existsByName(string $name): bool
    {
        foreach ($this->stored as $skill) {
            if ($skill->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function exists(SkillId $id): bool
    {
        foreach ($this->stored as $skill) {
            if ($skill->getId()->toString() === $id->toString()) {
                return true;
            }
        }

        return false;
    }

    public function fetchByName(string $name): Skill
    {
        foreach ($this->stored as $skill) {
            if ($skill->getName() === $name) {
                return $skill;
            }
        }

        throw SkillDoesNotExist::withName($name);
    }
}
