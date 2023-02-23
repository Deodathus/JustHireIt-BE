<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Query\GetJobCategoriesQuery;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetJobCategoriesController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'categories' => $this->queryBus->handle(
                    new GetJobCategoriesQuery()
                ),
            ]
        );
    }
}
