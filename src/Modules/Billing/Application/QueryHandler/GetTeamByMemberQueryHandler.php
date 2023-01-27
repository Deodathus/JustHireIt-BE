<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\QueryHandler;

use App\Modules\Billing\Domain\Enum\Features;
use App\Modules\Billing\Domain\Exception\MemberDoesNotBelongToTeam as MemberDoesNotBelongToTeamDomain;
use App\Modules\Billing\Domain\Repository\TeamRepository;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use App\Modules\Billing\ModuleApi\Application\DTO\Team;
use App\Modules\Billing\ModuleApi\Application\Exception\MemberDoesNotBelongToTeam;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamByMember;
use App\Shared\Application\Messenger\QueryHandler;

final class GetTeamByMemberQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TeamRepository $teamRepository
    ) {}

    public function __invoke(GetTeamByMember $getTeamByMember): Team
    {
        try {
            $team = $this->teamRepository->fetchByMember(TeamMemberId::fromString($getTeamByMember->teamMemberId));
        } catch (MemberDoesNotBelongToTeamDomain $exception) {
            throw MemberDoesNotBelongToTeam::withId($getTeamByMember->teamMemberId);
        }

        return new Team(
            $team->getId()->toString(),
            $team->getName(),
            array_map(
                static fn (Features $features): string => $features->name, $team->getFeatures()
            )
        );
    }
}
