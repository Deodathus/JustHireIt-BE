<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Query\GetJobPostsQuery;
use App\Modules\Job\Infrastructure\Http\Request\GetJobPostsRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetJobPostsController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(GetJobPostsRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'jobPosts' => $this->queryBus->handle(
                    new GetJobPostsQuery(
                        $request->page,
                        $request->perPage,
                        $request->category
                    )
                ),
            ]
        );
    }
}
