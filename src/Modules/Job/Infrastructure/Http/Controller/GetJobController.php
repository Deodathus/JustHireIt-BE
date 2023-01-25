<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Query\GetJobQuery;
use App\Modules\Job\Infrastructure\Http\Request\GetJobRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetJobController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(GetJobRequest $request): JsonResponse
    {
        return new JsonResponse([
            'job' => $this->queryBus->handle(new GetJobQuery($request->jobId)),
        ]);
    }
}
