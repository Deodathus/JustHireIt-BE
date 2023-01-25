<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Repository;

use App\Modules\Candidate\Domain\Entity\Candidate;

interface CandidateRepository
{
    public function store(Candidate $candidate): void;
}
