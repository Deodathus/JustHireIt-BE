<?php

declare(strict_types=1);

namespace App\Modules\Candidate\ModuleApi\Application\Command;

use App\Shared\Application\Messenger\Command;

final class CreateCandidate implements Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $lastName
    ) {}
}
