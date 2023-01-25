<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Service;

use App\Modules\Candidate\Application\Exception\SkillNameTakenException;
use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\Repository\SkillRepository;
use App\Modules\Candidate\Domain\Service\SkillPersister as SkillPersisterInterface;

final class SkillPersister implements SkillPersisterInterface
{
    public function __construct(
        private readonly SkillRepository $skillRepository
    ) {}

    public function store(Skill $skill): void
    {
        if ($this->skillRepository->existsByName($skill->getName())) {
            SkillNameTakenException::withName($skill->getName());
        }

        $this->skillRepository->store($skill);
    }
}
