<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Repository;

use App\Modules\Client\Domain\Entity\Group;
use App\Modules\Client\Domain\Enum\Permissions;
use App\Modules\Client\Domain\Repository\ClientGroupRepository as ClientGroupRepositoryInterface;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;
use Doctrine\DBAL\Connection;

final class ClientGroupRepository implements ClientGroupRepositoryInterface
{
    private const DB_TABLE_NAME = 'client_groups';
    private const DB_PERMISSIONS_TOGGLE_TABLE_NAME = 'client_group_permission_toggle';

    private const DB_CLIENTS_GROUPS_TABLE_NAME = 'clients_groups';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function store(Group $group): void
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
                'id' => $group->getId()->toString(),
                'ownerId' => $group->getOwner()->toString(),
                'name' => $group->getName(),
            ])
            ->executeStatement();

        foreach ($group->getPermissions() as $permission) {
            $this->connection
                ->createQueryBuilder()
                ->insert(self::DB_PERMISSIONS_TOGGLE_TABLE_NAME)
                ->values([
                    'group_id' => ':groupId',
                    'permission_name' => ':permissionName',
                    'status' => ':status'
                ])
                ->setParameters([
                    'groupId' => $group->getId()->toString(),
                    'permissionName' => $permission->name,
                    'status' => true,
                ])
                ->executeStatement();
        }
    }

    public function fetchByClient(ClientId $id): Group
    {
        $group = $this->connection
            ->createQueryBuilder()
            ->select(['g.id', 'g.name'])
            ->from(self::DB_TABLE_NAME, 'g')
            ->join('g', self::DB_CLIENTS_GROUPS_TABLE_NAME, 'cg', 'g.id = cg.group_id')
            ->where('cg.client_id = :clientId')
            ->setParameter('clientId', $id->toString())
            ->fetchAssociative();

        $permissions = $this->connection
            ->createQueryBuilder()
            ->select(['permission_name'])
            ->from(self::DB_PERMISSIONS_TOGGLE_TABLE_NAME)
            ->where('group_id = :groupId')
            ->andWhere('status = 1')
            ->setParameter('groupId', $group['id'])
            ->fetchAllAssociative();

        return new Group(
            GroupId::fromString($group['id']),
            $group['name'],
            $id,
            array_map(
                static fn(array $rawPermission) => Permissions::tryFrom($rawPermission['permission_name']), $permissions
            )
        );
    }

    public function assignClientToGroup(ClientId $id, GroupId $groupId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_CLIENTS_GROUPS_TABLE_NAME)
            ->values([
                'client_id' => ':clientId',
                'group_id' => ':groupId',
            ])
            ->setParameters([
                'clientId' => $id->toString(),
                'groupId' => $groupId->toString(),
            ])
            ->executeStatement();
    }
}
