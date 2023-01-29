<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\ViewModel;

final class SearchedCandidateViewModel
{
    /**
     * @param CandidateSkillViewModel[] $skills
     */
    public function __construct(
        public readonly string $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly array $skills
    ) {}
}
