<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Controller;

use App\Modules\Candidate\ModuleApi\Application\Command\CreateCandidate;
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
        if ($request->byGuest) {
            $applicantId = $this->commandBus->dispatch(
                new CreateCandidate(
                    $request->firstName,
                    $request->lastName
                )
            );
        } else {
            $applicantId = $request->applicantId;
        }

        $id = $this->commandBus->dispatch(new ApplyApplicationCommand(
            new ApplicationDTO(
                $request->jobPostId,
                $applicantId,
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
