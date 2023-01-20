<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Repository\ClientGroupRepository;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;

final class ClientToGroupAssigner implements ClientToGroupAssignerInterface
{
    public function __construct(
        private readonly ClientGroupRepository $groupRepository
    ) {}

    public function assign(ClientId $id, GroupId $groupId): void
    {
        $this->groupRepository->assignClientToGroup($id, $groupId);
    }
}
