<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Entity;

use App\Modules\Billing\Domain\ValueObject\InvitationCreatorId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamInvitationId;

class TeamInvitation
{
    public function __construct(
        private readonly TeamInvitationId $id,
        private readonly TeamId $teamId,
        private readonly InvitationCreatorId $invitationCreatorId,
        private readonly \DateTimeImmutable $activeUntil
    ) {}

    public function getId(): TeamInvitationId
    {
        return $this->id;
    }

    public function getTeamId(): TeamId
    {
        return $this->teamId;
    }

    public function getInvitationCreatorId(): InvitationCreatorId
    {
        return $this->invitationCreatorId;
    }

    public function getActiveUntil(): \DateTimeImmutable
    {
        return $this->activeUntil;
    }
}
