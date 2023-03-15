<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Infrastructure\Http\Controller;

use App\Modules\Authentication\Application\Query\GetUserTokenByCredentialsQuery;
use App\Modules\Authentication\Infrastructure\Http\Request\LoginRequest;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SignInController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'token' => $this->queryBus->handle(
                    new GetUserTokenByCredentialsQuery(
                        $request->login,
                        $request->rawPassword
                    )
                ),
            ]
        );
    }
}
