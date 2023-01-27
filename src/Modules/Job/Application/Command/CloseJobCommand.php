<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Shared\Application\Messenger\Command;

final class CloseJobCommand implements Command
{
    public function __construct(
        public readonly string $jobId,
        public readonly string $token
    ) {}
}
