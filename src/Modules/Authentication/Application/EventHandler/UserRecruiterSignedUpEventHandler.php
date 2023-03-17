<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\EventHandler;

use App\Modules\Authentication\Domain\Event\UserRecruiterSignedUp;
use App\Modules\Billing\ModuleApi\Application\Command\AssignMemberToTeamCommand;
use App\Modules\Billing\ModuleApi\Application\Command\CreateTeamCommand;
use App\Modules\Job\ModuleApi\Application\Command\CreateCompanyCommand;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\EventHandler;

final class UserRecruiterSignedUpEventHandler implements EventHandler
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(UserRecruiterSignedUp $event): void
    {
        $teamId = $this->commandBus->dispatch(
            new CreateTeamCommand($event->companyName, $event->id)
        );

        $this->commandBus->dispatch(
            new AssignMemberToTeamCommand($teamId, $event->id)
        );

        $this->commandBus->dispatch(
            new CreateCompanyCommand($event->token, $event->companyName, $event->companyDescription)
        );
    }
}
