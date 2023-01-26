<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Repository;

use App\Modules\Billing\Domain\Entity\TeamInvitation;

interface TeamInvitationRepository
{
    public function store(TeamInvitation $invitation): void;
}
