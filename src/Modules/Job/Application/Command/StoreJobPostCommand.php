<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Shared\Application\Messenger\Command;

final class StoreJobPostCommand implements Command
{
    public function __construct(
        public readonly string $jobId,
        public readonly JobPostDTO $jobPost
    ) {}
}
