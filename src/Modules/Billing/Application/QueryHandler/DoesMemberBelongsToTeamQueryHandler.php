<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\QueryHandler;

use App\Modules\Billing\Domain\Repository\TeamRepository;
use App\Modules\Billing\Domain\ValueObject\TeamId;
use App\Modules\Billing\Domain\ValueObject\TeamMemberId;
use App\Modules\Billing\ModuleApi\Application\Query\DoesMemberBelongsToTeamQuery;
use App\Shared\Application\Messenger\QueryHandler;

final class DoesMemberBelongsToTeamQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TeamRepository $teamRepository
    ) {}

    public function __invoke(DoesMemberBelongsToTeamQuery $query): bool
    {
        return $this->teamRepository->isMemberOfTeam(
            TeamMemberId::fromString($query->memberId),
            TeamId::fromString($query->teamId)
        );
    }
}
