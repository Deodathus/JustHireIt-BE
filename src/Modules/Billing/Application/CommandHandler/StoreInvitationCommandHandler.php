<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\CommandHandler;

use App\Modules\Authentication\ModuleApi\Application\Query\GetUserIdByTokenQuery;
use App\Modules\Billing\Application\Command\StoreInvitationCommand;
use App\Modules\Billing\Application\Exception\InvitationCreatorMustBePartOfTeam;
use App\Modules\Billing\Application\Exception\TeamDoesNotExist;
use App\Modules\Billing\Domain\Entity\TeamInvitation;
use App\Modules\Billing\Domain\Repository\TeamRepository;
use App\Modules\Billing\Domain\Service\InvitationPersisterInterface;
use App\Modules\Billing\Domain\ValueObject\InvitationCreatorId;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamInvitationId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\QueryBus;

final class StoreInvitationCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly InvitationPersisterInterface $invitationPersister,
        private readonly TeamRepository $teamRepository,
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(StoreInvitationCommand $command): string
    {
        $id = TeamInvitationId::generate();
        $teamId = TeamId::fromString($command->invitation->teamId);
        $creatorId = $this->queryBus->handle(new GetUserIdByTokenQuery($command->invitation->creatorApiToken));

        $invitationCreator = InvitationCreatorId::fromString($creatorId);

        if (!$this->teamRepository->existsById($teamId)) {
            throw TeamDoesNotExist::withId($teamId->toString());
        }

        if (!$this->teamRepository->isMemberOfTeam(TeamMemberId::fromString($invitationCreator->toString()), $teamId)) {
            throw InvitationCreatorMustBePartOfTeam::withIds(
                $creatorId,
                $teamId->toString()
            );
        }

        $this->invitationPersister->store(
            new TeamInvitation(
                $id,
                $teamId,
                $invitationCreator,
                new \DateTimeImmutable('+3day')
            )
        );

        return $id->toString();
    }
}
