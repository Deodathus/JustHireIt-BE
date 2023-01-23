<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\EventHandler;

use App\Modules\Authentication\Domain\Event\UserSignedUp;
use App\Modules\Billing\ModuleApi\Application\Command\AssignMemberToTeamCommand;
use App\Modules\Billing\ModuleApi\Application\Command\CreateTeamCommand;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\EventHandler;

final class UserSignedUpEventHandler implements EventHandler
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(UserSignedUp $event): void
    {
        $teamId = $this->commandBus->dispatch(
            new CreateTeamCommand('Team', $event->id)
        );

        $this->commandBus->dispatch(
            new AssignMemberToTeamCommand($teamId, $event->id)
        );
    }
}
