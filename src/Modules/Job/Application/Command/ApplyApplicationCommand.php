<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Modules\Job\Application\DTO\ApplicationDTO;
use App\Shared\Application\Messenger\Command;

final class ApplyApplicationCommand implements Command
{
    public function __construct(
        public readonly ApplicationDTO $application
    ) {}
}
