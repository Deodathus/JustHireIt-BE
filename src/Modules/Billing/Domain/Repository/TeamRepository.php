<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Repository;

use App\Modules\Billing\Domain\Entity\Team;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;

interface TeamRepository
{
    public function store(Team $team): void;

    public function fetchByMember(TeamMemberId $id): Team;

    public function assignMemberToTeam(TeamMemberId $id, TeamId $teamId): void;

    public function existsById(TeamId $id): bool;

    public function isMemberOfTeam(TeamMemberId $teamMemberId, TeamId $teamId): bool;
}
