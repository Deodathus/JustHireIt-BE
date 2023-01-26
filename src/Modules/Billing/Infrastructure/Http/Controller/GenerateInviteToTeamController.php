<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Http\Controller;

use App\Modules\Billing\Application\Command\StoreInvitationCommand;
use App\Modules\Billing\Application\DTO\InvitationDTO;
use App\Modules\Billing\Infrastructure\Http\Request\GenerateInviteToTeamRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class GenerateInviteToTeamController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(GenerateInviteToTeamRequest $request): JsonResponse
    {
        $id = $this->commandBus->dispatch(
            new StoreInvitationCommand(
                new InvitationDTO(
                    $request->teamId,
                    $request->creatorApiToken
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
