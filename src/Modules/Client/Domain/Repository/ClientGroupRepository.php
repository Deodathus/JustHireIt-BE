<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Repository;

use App\Modules\Client\Domain\Entity\Group;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;

interface ClientGroupRepository
{
    public function store(Group $group): void;

    public function fetchByClient(ClientId $id): Group;

    public function assignClientToGroup(ClientId $id, GroupId $groupId): void;
}
