<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Search;

final class SearchQuery
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 20,
        public readonly ?string $requirement = null
    ) {}
}
