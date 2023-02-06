<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Shared\Application\Messenger\Command;

final class StoreCompanyCommand implements Command
{
    public function __construct(
        public readonly string $ownerToken,
        public readonly string $name,
        public readonly string $description
    ) {}
}
