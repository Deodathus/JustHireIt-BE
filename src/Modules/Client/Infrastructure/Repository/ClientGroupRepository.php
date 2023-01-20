<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Repository;

use App\Modules\Client\Domain\Entity\Group;
use App\Modules\Client\Domain\Repository\ClientGroupRepository as ClientGroupRepositoryInterface;
use Doctrine\DBAL\Connection;

final class ClientGroupRepository implements ClientGroupRepositoryInterface
{
    private const DB_TABLE_NAME = 'client_groups';
    private const DB_PERMISSIONS_TOGGLE_TABLE_NAME = 'client_group_permission_toggle';

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
}
