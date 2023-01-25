<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Command;

use App\Modules\Candidate\Application\DTO\CandidateDTO;
use App\Shared\Application\Messenger\Command;

final class StoreCandidateCommand implements Command
{
    public function __construct(
        public readonly CandidateDTO $candidate
    ) {}
}
