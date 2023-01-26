<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Repository;

use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\Repository\TeamInvitationRepository as TeamInvitationRepositoryInterface;
use App\Modules\Billing\Domain\ValueObject\InvitationCreatorId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamInvitationId;
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
                'active' => ':active',
                'active_until' => ':activeUntil'
            ])
            ->setParameters([
                'id' => $invitation->getId()->toString(),
                'teamId' => $invitation->getTeamId()->toString(),
                'creatorId' => $invitation->getInvitationCreatorId()->toString(),
                'active' => $invitation->getActiveStatus(),
                'activeUntil' => $invitation->getActiveUntil()->format('Y-m-d H:i:s'),
            ])
            ->executeStatement();
    }

    public function disactivate(TeamInvitation $invitation): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DB_TABLE_NAME)
            ->set('active', ':active')
            ->setParameters([
                'active' => (int) $invitation->getActiveStatus(),
            ])
            ->executeStatement();
    }

    public function fetchById(TeamInvitationId $invitationId): TeamInvitation
    {
        $rawInvitation = $this->connection
            ->createQueryBuilder()
            ->select('id', 'team_id', 'creator_id', 'active', 'active_until')
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameters([
                'id' => $invitationId->toString(),
            ])
            ->fetchAssociative();

        return new TeamInvitation(
            $invitationId,
            TeamId::fromString($rawInvitation['team_id']),
            InvitationCreatorId::fromString($rawInvitation['creator_id']),
            (bool) $rawInvitation['active'],
            new \DateTimeImmutable($rawInvitation['active_until'])
        );
    }
}
