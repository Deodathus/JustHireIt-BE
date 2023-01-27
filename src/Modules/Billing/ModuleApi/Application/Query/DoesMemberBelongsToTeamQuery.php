<?php

declare(strict_types=1);

namespace App\Modules\Billing\ModuleApi\Application\Query;

use App\Shared\Application\Messenger\Query;

final class DoesMemberBelongsToTeamQuery implements Query
{
    public function __construct(
        public readonly string $memberId,
        public readonly string $teamId
    ) {}
}
