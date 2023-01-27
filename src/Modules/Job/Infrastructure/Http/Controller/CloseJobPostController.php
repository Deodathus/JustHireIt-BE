<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\CloseJobPostCommand;
use App\Modules\Job\Infrastructure\Http\Request\CloseJobPostRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CloseJobPostController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(CloseJobPostRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new CloseJobPostCommand(
                $request->jobId,
                $request->jobPostId,
                $request->token
            )
        );

        return new JsonResponse(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
