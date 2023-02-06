<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\StoreCompanyCommand;
use App\Modules\Job\Infrastructure\Http\Request\StoreCompanyRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreCompanyController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreCompanyRequest $request): JsonResponse
    {
        return new JsonResponse(
            [
                'id' => $this->commandBus->dispatch(
                    new StoreCompanyCommand(
                        $request->apiToken,
                        $request->name,
                        $request->description
                    )
                )
            ],
            Response::HTTP_CREATED
        );
    }
}
