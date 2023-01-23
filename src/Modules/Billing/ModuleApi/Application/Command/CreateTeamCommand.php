<?php

declare(strict_types=1);

namespace App\Modules\Billing\ModuleApi\Application\Command;

use App\Shared\Application\Messenger\Command;

final class CreateTeamCommand implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $ownerId
    ) {}
}
