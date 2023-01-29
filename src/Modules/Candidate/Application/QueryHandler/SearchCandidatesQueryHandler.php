<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\QueryHandler;

use App\Modules\Candidate\Application\Query\SearchCandidatesQuery;
use App\Modules\Candidate\Application\ReadModel\CandidateReadModel;
use App\Modules\Candidate\Application\ViewModel\SearchedCandidateViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class SearchCandidatesQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CandidateReadModel $readModel
    ) {}

    /**
     * @return SearchedCandidateViewModel[]
     */
    public function __invoke(SearchCandidatesQuery $query): array
    {
        return $this->readModel->search($query->searchQuery);
    }
}
