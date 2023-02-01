<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Query;

use App\Shared\Application\Messenger\Query;

final class GetJobPostQuery implements Query
{
    public function __construct(
        public readonly string $jobId,
        public readonly string $jobPostId
    ) {}
}
