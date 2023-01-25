<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Entity;

use App\Modules\Candidate\Domain\ValueObject\CandidateId;

class Candidate
{
    /**
     * @param CandidateSkill[] $skills
     */
    public function __construct(
        private readonly CandidateId $id,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly array $skills
    ) {}

    public function getId(): CandidateId
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }
}
