<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Domain\Service;

use App\Modules\Candidate\Domain\Entity\Candidate;

interface CandidatePersister
{
    public function store(Candidate $candidate): void;
}
