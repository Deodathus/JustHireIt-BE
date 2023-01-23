<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\CommandHandler;

use App\Modules\Billing\Domain\Service\MemberToTeamAssignerInterface;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use App\Modules\Billing\ModuleApi\Application\Command\AssignMemberToTeamCommand;
use App\Shared\Application\Messenger\CommandHandler;

final class AssignMemberToTeamCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly MemberToTeamAssignerInterface $memberToTeamAssigner
    ) {}

    public function __invoke(AssignMemberToTeamCommand $assignMemberToTeamCommand): void
    {
        $this->memberToTeamAssigner->assign(
            TeamMemberId::fromString($assignMemberToTeamCommand->memberId),
            TeamId::fromString($assignMemberToTeamCommand->teamId)
        );
    }
}
