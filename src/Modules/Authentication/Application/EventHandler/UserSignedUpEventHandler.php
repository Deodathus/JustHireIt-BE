<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\EventHandler;

use App\Modules\Authentication\Domain\Event\UserSignedUp;
use App\Modules\Billing\ModuleApi\Application\Command\AssignMemberToTeamCommand;
use App\Modules\Billing\ModuleApi\Application\Command\CreateTeamCommand;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamIdByName;
use App\Shared\Application\Messenger\CommandBus;
use App\Shared\Application\Messenger\EventHandler;
use App\Shared\Application\Messenger\QueryBus;

final class UserSignedUpEventHandler implements EventHandler
{
    private const USER_TEAM_NAME = 'Users';

    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(UserSignedUp $event): void
    {
        try {
            $teamId = $this->queryBus->handle(
                new GetTeamIdByName(self::USER_TEAM_NAME)
            );
        } catch (\Throwable $exception) {
            $teamId = $this->commandBus->dispatch(
                new CreateTeamCommand(self::USER_TEAM_NAME, $event->id, false)
            );
        }

        $this->commandBus->dispatch(
            new AssignMemberToTeamCommand($teamId, $event->id)
        );
    }
}
