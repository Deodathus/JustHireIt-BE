<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Repository\TeamRepository;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;

final class MemberToTeamAssigner implements MemberToTeamAssignerInterface
{
    public function __construct(
        private readonly TeamRepository $teamRepository
    ) {}

    public function assign(TeamMemberId $id, TeamId $teamId): void
    {
        $this->teamRepository->assignMemberToTeam($id, $teamId);
    }
}
