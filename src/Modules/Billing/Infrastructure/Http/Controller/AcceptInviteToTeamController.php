<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Http\Controller;

use App\Modules\Billing\Application\Command\StoreInvitedTeamMemberCommand;
use App\Modules\Billing\Application\DTO\InvitedMemberDTO;
use App\Modules\Billing\Infrastructure\Http\Request\AcceptInviteToTeamRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AcceptInviteToTeamController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(AcceptInviteToTeamRequest $request): JsonResponse
    {
        $id = $this->commandBus->dispatch(
            new StoreInvitedTeamMemberCommand(
                new InvitedMemberDTO(
                    $request->teamId,
                    $request->invitationId,
                    $request->email,
                    $request->login,
                    $request->password
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
