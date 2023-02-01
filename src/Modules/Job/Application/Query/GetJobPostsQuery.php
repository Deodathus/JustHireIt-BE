<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Query;

use App\Shared\Application\Messenger\Query;

final class GetJobPostsQuery implements Query
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
        public readonly ?string $category
    ) {}
}
