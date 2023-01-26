<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Command;

use App\Modules\Billing\Application\DTO\InvitationDTO;
use App\Shared\Application\Messenger\Command;

final class StoreInvitationCommand implements Command
{
    public function __construct(
        public readonly InvitationDTO $invitation
    ) {}
}
