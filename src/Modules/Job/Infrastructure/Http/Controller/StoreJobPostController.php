<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\StoreJobPostCommand;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Application\DTO\JobPostPropertyDTO;
use App\Modules\Job\Application\DTO\JobPostRequirementDTO;
use App\Modules\Job\Infrastructure\Http\Request\StoreJobPostRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreJobPostController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreJobPostRequest $request): JsonResponse
    {
        $properties = [];
        $requirements = [];

        foreach ($request->properties as $property) {
            $properties[] = new JobPostPropertyDTO($property['type'], $property['value']);
        }

        foreach ($request->requirements as $requirement) {
            $requirements[] = new JobPostRequirementDTO($requirement['id'], $requirement['score']);
        }

        $id = $this->commandBus->dispatch(
            new StoreJobPostCommand(
                $request->jobId,
                new JobPostDTO($request->name, $properties, $requirements)
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
