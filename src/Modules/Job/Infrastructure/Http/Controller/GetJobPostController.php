<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Query\GetJobPostQuery;
use App\Modules\Job\Infrastructure\Http\Request\GetJobPostRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetJobPostController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(GetJobPostRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'jobPost' => $this->queryBus->handle(
                    new GetJobPostQuery($request->jobId, $request->jobPostId)
                )
            ],
            Response::HTTP_OK
        );
    }
}
