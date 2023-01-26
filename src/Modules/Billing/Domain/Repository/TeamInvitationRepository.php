<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Repository;

use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\ValueObject\TeamInvitationId;

interface TeamInvitationRepository
{
    public function store(TeamInvitation $invitation): void;

    public function disactivate(TeamInvitation $invitation): void;

    public function fetchById(TeamInvitationId $invitationId): TeamInvitation;
}
