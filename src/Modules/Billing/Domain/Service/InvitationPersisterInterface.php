<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\TeamInvitation;

interface InvitationPersisterInterface
{
    public function store(TeamInvitation $teamInvitation): void;
}
