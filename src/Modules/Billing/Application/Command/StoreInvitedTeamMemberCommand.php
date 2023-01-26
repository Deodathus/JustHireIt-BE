<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Command;

use App\Modules\Billing\Application\DTO\InvitedMemberDTO;
use App\Shared\Application\Messenger\Command;

final class StoreInvitedTeamMemberCommand implements Command
{
    public function __construct(
        public readonly InvitedMemberDTO $invitedMember
    ) {}
}
