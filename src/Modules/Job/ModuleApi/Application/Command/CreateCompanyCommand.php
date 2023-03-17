<?php

declare(strict_types=1);

namespace App\Modules\Job\ModuleApi\Application\Command;

use App\Shared\Application\Messenger\Command;

final class CreateCompanyCommand implements Command
{
    public function __construct(
        public readonly string $ownerToken,
        public readonly string $companyName,
        public readonly string $companyDescription
    ) {}
}
