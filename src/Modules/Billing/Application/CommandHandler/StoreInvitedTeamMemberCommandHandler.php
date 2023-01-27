<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Command\CreateUserCommand;
use App\Modules\Authentication\ModuleApi\Application\DTO\UserDTO;
use App\Modules\Billing\Application\Command\StoreInvitedTeamMemberCommand;
use App\Modules\Billing\Application\Exception\InvitationIsNotActive;
use App\Modules\Billing\Domain\Repository\TeamInvitationRepository;
use App\Modules\Billing\Domain\Service\InvitationDisactivatorInterface;
use App\Modules\Billing\Domain\ValueObject\TeamInvitationId;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\CommandHandler;

final class StoreInvitedTeamMemberCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly InvitationDisactivatorInterface $disactivator,
        private readonly TeamInvitationRepository $teamInvitationRepository
    ) {}

    public function __invoke(StoreInvitedTeamMemberCommand $command): string
    {
        $invitation = $this->teamInvitationRepository->fetchById(
            TeamInvitationId::fromString($command->invitedMember->invitationId)
        );

        if (!$invitation->isActive()) {
            throw InvitationIsNotActive::withId($invitation->getId()->toString());
        }

        $this->disactivator->disactivate($invitation);

        $id = $this->commandBus->dispatch(
            new CreateUserCommand(
                new UserDTO(
                    $command->invitedMember->email,
                    $command->invitedMember->login,
                    $command->invitedMember->password
                )
            )
        );

        return $id;
    }
}
