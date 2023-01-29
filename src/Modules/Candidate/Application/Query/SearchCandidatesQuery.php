<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Query;

use App\Modules\Candidate\Application\Search\SearchQuery;
use App\Shared\Application\Messenger\Query;

final class SearchCandidatesQuery implements Query
{
    public function __construct(
        public readonly SearchQuery $searchQuery
    ) {}
}
