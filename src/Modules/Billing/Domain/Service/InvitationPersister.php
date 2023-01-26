<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Service;

use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\Repository\TeamInvitationRepository;

final class InvitationPersister implements InvitationPersisterInterface
{
    public function __construct(
        private readonly TeamInvitationRepository $invitationRepository
    ) {}

    public function store(TeamInvitation $teamInvitation): void
    {
        $this->invitationRepository->store($teamInvitation);
    }
}
