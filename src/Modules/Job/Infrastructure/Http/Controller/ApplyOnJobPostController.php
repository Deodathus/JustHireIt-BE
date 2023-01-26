<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Job\Application\Command\ApplyApplicationCommand;
use App\Modules\Job\Application\DTO\ApplicationDTO;
use App\Modules\Job\Infrastructure\Http\Request\ApplyOnJobPostRequest;
use App\Shared\Application\Messenger\CommandBus;
use App\SharedInfrastructure\Adapter\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApplyOnJobPostController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(ApplyOnJobPostRequest $request): JsonResponse
    {
        $id = $this->commandBus->dispatch(new ApplyApplicationCommand(
            new ApplicationDTO(
                $request->jobPostId,
                $request->applicantId,
                $request->introduction,
                new UploadedFile($request->cv),
                $request->byGuest
            )
        ));

        return new JsonResponse(
            [
                'id' => $id,
            ],
            Response::HTTP_CREATED
        );
    }
}
