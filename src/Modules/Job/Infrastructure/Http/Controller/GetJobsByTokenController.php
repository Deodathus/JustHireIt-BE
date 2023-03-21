<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Query\GetJobsByTokenQuery;
use App\Modules\Job\Infrastructure\Http\Request\GetJobsByTokenRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetJobsByTokenController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(GetJobsByTokenRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'jobs' => $this->queryBus->handle(
                    new GetJobsByTokenQuery($request->token)
                ),
            ]
        );
    }
}
