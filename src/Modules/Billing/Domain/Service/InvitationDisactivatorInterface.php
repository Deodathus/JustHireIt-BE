<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\TeamInvitation;

interface InvitationDisactivatorInterface
{
    public function disactivate(TeamInvitation $invitation): void;
}
