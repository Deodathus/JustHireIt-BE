<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Service;

use App\Modules\Candidate\Domain\Entity\Candidate;
use App\Modules\Candidate\Domain\Repository\CandidateRepository;
use App\Modules\Candidate\Domain\Service\CandidatePersister as CandidatePersisterInterface;

final class CandidatePersister implements CandidatePersisterInterface
{
    public function __construct(
        private readonly CandidateRepository $candidateRepository
    ) {}

    public function store(Candidate $candidate): void
    {
        $this->candidateRepository->store($candidate);
    }
}
