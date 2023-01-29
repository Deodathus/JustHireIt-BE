<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\ReadModel;

use App\Modules\Candidate\Application\Search\SearchQuery;

interface CandidateReadModel
{
    public function search(SearchQuery $query): array;
}
