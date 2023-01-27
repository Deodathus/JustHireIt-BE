<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Repository;

use App\Modules\Billing\Domain\Entity\Team;
use App\Modules\Billing\Domain\Enum\Features;
use App\Modules\Billing\Domain\Exception\MemberDoesNotBelongToTeam;
use App\Modules\Billing\Domain\Repository\TeamRepository as TeamRepositoryInterface;
use App\Modules\Billing\Domain\ValueObject\OwnerId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use Doctrine\DBAL\Connection;

final class TeamRepository implements TeamRepositoryInterface
{
    private const DB_TABLE_NAME = 'teams';
    private const DB_FEATURE_TOGGLE_TABLE_NAME = 'team_feature_toggle';

    private const DB_TEAM_MEMBERS_TEAMS_TABLE_NAME = 'team_members_teams';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(Team $team): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'owner_id' => ':ownerId',
                'name' => ':name',
            ])
            ->setParameters([
                'id' => $team->getId()->toString(),
                'ownerId' => $team->getOwner()->toString(),
                'name' => $team->getName(),
            ])
            ->executeStatement();

        foreach ($team->getFeatures() as $permission) {
            $this->connection
                ->createQueryBuilder()
                ->insert(self::DB_FEATURE_TOGGLE_TABLE_NAME)
                ->values([
                    'team_id' => ':teamId',
                    'feature_name' => ':featureName',
                    'status' => ':status'
                ])
                ->setParameters([
                    'teamId' => $team->getId()->toString(),
                    'featureName' => $permission->name,
                    'status' => true,
                ])
                ->executeStatement();
        }
    }

    public function fetchByMember(TeamMemberId $id): Team
    {
        $team = $this->connection
            ->createQueryBuilder()
            ->select(['t.id', 't.name', 't.owner_id'])
            ->from(self::DB_TABLE_NAME, 't')
            ->join('t', self::DB_TEAM_MEMBERS_TEAMS_TABLE_NAME, 'tmt', 't.id = tmt.team_id')
            ->where('tmt.member_id = :memberId')
            ->setParameter('memberId', $id->toString())
            ->fetchAssociative();

        if (!$team) {
            throw MemberDoesNotBelongToTeam::withId($id->toString());
        }

        $features = $this->connection
            ->createQueryBuilder()
            ->select(['feature_name'])
            ->from(self::DB_FEATURE_TOGGLE_TABLE_NAME)
            ->where('team_id = :teamId')
            ->andWhere('status = 1')
            ->setParameter('teamId', $team['id'])
            ->fetchAllAssociative();

        return new Team(
            TeamId::fromString($team['id']),
            $team['name'],
            OwnerId::fromString($team['owner_id']),
            [],
            array_map(
                static fn(array $rawFeature) => Features::tryFrom($rawFeature['feature_name']), $features
            )
        );
    }

    public function assignMemberToTeam(TeamMemberId $id, TeamId $teamId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TEAM_MEMBERS_TEAMS_TABLE_NAME)
            ->values([
                'member_id' => ':memberId',
                'team_id' => ':teamId',
            ])
            ->setParameters([
                'memberId' => $id->toString(),
                'teamId' => $teamId->toString(),
            ])
            ->executeStatement();
    }

    public function existsById(TeamId $id): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select(['id'])
            ->from(self::DB_TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id->toString())
            ->fetchAllAssociative();

        return $found > 0;
    }

    public function isMemberOfTeam(TeamMemberId $teamMemberId, TeamId $teamId): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select(['team_id'])
            ->from(self::DB_TEAM_MEMBERS_TEAMS_TABLE_NAME)
            ->where('team_id = :teamId')
            ->andWhere('member_id = :memberId')
            ->setParameters([
                'teamId' => $teamId->toString(),
                'memberId' => $teamMemberId->toString(),
            ])
            ->fetchAllAssociative();

        return count($found) > 0;
    }
}
