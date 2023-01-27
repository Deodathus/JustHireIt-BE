<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\StoreCategoryCommand;
use App\Modules\Job\Application\DTO\JobCategoryDTO;
use App\Modules\Job\Infrastructure\Http\Request\StoreJobCategoryRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreJobCategoryController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreJobCategoryRequest $request): JsonResponse
    {
        $id = $this->commandBus->dispatch(
            new StoreCategoryCommand(
                new JobCategoryDTO($request->name)
            )
        );

        return new JsonResponse(
            [
                'id' => $id,
            ],
            Response::HTTP_CREATED
        );
    }
}
