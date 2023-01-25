<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Entity;

use App\Modules\Candidate\Domain\ValueObject\SkillId;

class Skill
{
    public function __construct(
        private readonly SkillId $id,
        private readonly string $name
    ) {}

    public function getId(): SkillId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
