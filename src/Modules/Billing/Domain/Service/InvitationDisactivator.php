<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\Repository\TeamInvitationRepository;

final class InvitationDisactivator implements InvitationDisactivatorInterface
{
    public function __construct(
        private readonly TeamInvitationRepository $teamInvitationRepository
    ) {}

    public function disactivate(TeamInvitation $invitation): void
    {
        $invitation->disactivate();

        $this->teamInvitationRepository->disactivate($invitation);
    }
}
