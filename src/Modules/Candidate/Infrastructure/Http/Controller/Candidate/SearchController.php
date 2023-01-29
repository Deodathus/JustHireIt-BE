<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Controller\Candidate;

use App\Modules\Candidate\Application\Query\SearchCandidatesQuery;
use App\Modules\Candidate\Application\Search\Filter;
use App\Modules\Candidate\Application\Search\MustHaves;
use App\Modules\Candidate\Application\Search\SearchQuery;
use App\Modules\Candidate\Infrastructure\Http\Request\SearchCandidatesRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SearchController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(SearchCandidatesRequest $request): JsonResponse
    {
        $mustHaves = [];
        foreach ($request->filters['mustHave'] as $mustHaveFilter) {
            $skillId = array_keys($mustHaveFilter)[0];
            $mustHaves[] = new Filter($skillId, $mustHaveFilter[$skillId]);
        }

        $result = $this->queryBus->handle(
            new SearchCandidatesQuery(
                new SearchQuery(
                    $request->perPage,
                    $request->page,
                    new MustHaves($mustHaves)
                )
            )
        );

        return new JsonResponse(
            [
                'results' => $result,
            ]
        );
    }
}
