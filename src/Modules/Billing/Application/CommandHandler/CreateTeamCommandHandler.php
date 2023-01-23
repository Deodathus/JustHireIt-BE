<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\CommandHandler;

use App\Modules\Billing\Domain\Entity\Plan;
use App\Modules\Billing\Domain\Entity\Team;
use App\Modules\Billing\Domain\Service\TeamPersisterInterface;
use App\Modules\Billing\Domain\ValueObject\OwnerId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use App\Modules\Billing\ModuleApi\Application\Command\CreateTeamCommand;
use App\Shared\Application\Messenger\CommandHandler;

final class CreateTeamCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly TeamPersisterInterface $teamPersister
    ) {}

    public function __invoke(CreateTeamCommand $createTeamCommand): string
    {
        $teamId = TeamId::generate();

        $this->teamPersister->store(
            new Team(
                $teamId,
                $createTeamCommand->name,
                OwnerId::fromString($createTeamCommand->ownerId),
                [
                    TeamMemberId::fromString($createTeamCommand->ownerId),
                ],
                Plan::START_PLAN_FEATURES
            )
        );

        return $teamId->toString();
    }
}
