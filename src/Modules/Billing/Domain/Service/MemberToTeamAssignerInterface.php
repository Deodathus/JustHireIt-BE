<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;

interface MemberToTeamAssignerInterface
{
    public function assign(TeamMemberId $id, TeamId $teamId): void;
}
