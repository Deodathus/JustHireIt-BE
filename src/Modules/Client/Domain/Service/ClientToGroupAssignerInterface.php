<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;

interface ClientToGroupAssignerInterface
{
    public function assign(ClientId $id, GroupId $groupId): void;
}
