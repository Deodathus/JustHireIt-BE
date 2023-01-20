<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Http\Controller;

use App\Modules\Client\Application\Query\GetMeQuery;
use App\Modules\Client\Infrastructure\Http\Request\MeRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GetMeController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(MeRequest $request): JsonResponse
    {
        $me = $this->queryBus->handle(
            new GetMeQuery($request->token)
        );

        return new JsonResponse(
            [
                'me' => $me,
            ],
            Response::HTTP_OK
        );
    }
}
