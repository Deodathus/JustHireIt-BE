<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\StoreJobCommand;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Application\DTO\JobPostPropertyDTO;
use App\Modules\Job\Infrastructure\Http\Request\StoreJobRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreJobRequest $storeJobRequest): JsonResponse
    {
        $jobPosts = [];

        foreach ($storeJobRequest->jobPosts as $jobPost) {
            $properties = [];

            foreach ($jobPost['properties'] as $property) {
                $properties[] = new JobPostPropertyDTO($property['type'], $property['value']);
            }

            $jobPosts[] = new JobPostDTO($jobPost['name'], $properties);
        }

        $id = $this->commandBus->dispatch(
            new StoreJobCommand(
                new JobDTO(
                    $storeJobRequest->name,
                    $storeJobRequest->ownerToken,
                    $jobPosts
                )
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
