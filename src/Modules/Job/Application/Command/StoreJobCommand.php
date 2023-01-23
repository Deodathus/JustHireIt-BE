<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Modules\Job\Application\DTO\JobDTO;
use App\Shared\Application\Messenger\Command;

final class StoreJobCommand implements Command
{
    public function __construct(
        public readonly JobDTO $job
    ) {}
}
