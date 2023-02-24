<?php

declare(strict_types=1);

namespace App\Tests\Modules\Candidate\Util;

use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\Repository\SkillRepository;
use App\Modules\Candidate\Domain\Service\SkillPersister;

final class SkillPersisterStub implements SkillPersister
{
    public function __construct(
        private readonly SkillRepository $skillRepository
    ) {}

    public function store(Skill $skill): void
    {
        $this->skillRepository->store($skill);
    }
}
