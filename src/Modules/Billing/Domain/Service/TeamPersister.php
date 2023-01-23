<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\Team;
use App\Modules\Billing\Domain\Repository\TeamRepository;

final class TeamPersister implements TeamPersisterInterface
{
    public function __construct(
        private readonly TeamRepository $teamRepository
    ) {}

    public function store(Team $group): void
    {
        $this->teamRepository->store($group);
    }
}
