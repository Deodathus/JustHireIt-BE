<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\DTO;

final class CandidateDTO
{
    /**
     * @param CandidateSkillDTO[] $skills
     */
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly array $skills
    ) {}
}
