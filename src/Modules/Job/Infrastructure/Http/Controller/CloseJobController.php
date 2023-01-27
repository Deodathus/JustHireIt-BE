<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\CloseJobCommand;
use App\Modules\Job\Infrastructure\Http\Request\CloseJobRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CloseJobController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(CloseJobRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(new CloseJobCommand($request->jobId, $request->token));

        return new JsonResponse(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
