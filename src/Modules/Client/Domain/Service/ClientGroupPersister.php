<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Group;
use App\Modules\Client\Domain\Repository\ClientGroupRepository;

final class ClientGroupPersister implements ClientGroupPersisterInterface
{
    public function __construct(
        private readonly ClientGroupRepository $clientGroupRepository
    ) {}

    public function store(Group $group): void
    {
        $this->clientGroupRepository->store($group);
    }
}
