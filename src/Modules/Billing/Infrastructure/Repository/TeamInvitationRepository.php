<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Repository;

use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\Repository\TeamInvitationRepository as TeamInvitationRepositoryInterface;
use Doctrine\DBAL\Connection;

final class TeamInvitationRepository implements TeamInvitationRepositoryInterface
{
    private const DB_TABLE_NAME = 'team_invitations';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(TeamInvitation $invitation): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'team_id' => ':teamId',
                'creator_id' => ':creatorId',
                'active_until' => ':activeUntil'
            ])
            ->setParameters([
                'id' => $invitation->getId()->toString(),
                'teamId' => $invitation->getTeamId()->toString(),
                'creatorId' => $invitation->getInvitationCreatorId()->toString(),
                'activeUntil' => $invitation->getActiveUntil()->format('Y-m-d H:i:s'),
            ])
            ->executeStatement();
    }
}
