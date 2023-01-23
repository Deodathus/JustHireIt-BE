<?php

declare(strict_types=1);

namespace App\Modules\Billing\ModuleApi\Application\Command;

use App\Shared\Application\Messenger\Command;

final class AssignMemberToTeamCommand implements Command
{
    public function __construct(
        public readonly string $teamId,
        public readonly string $memberId
    ) {}
}
