<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\QueryHandler;

use App\Modules\Billing\Domain\Repository\TeamRepository;
use App\Modules\Billing\ModuleApi\Application\Query\GetTeamIdByName;
use App\Shared\Application\Messenger\QueryHandler;

final class GetTeamIdByNameQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly TeamRepository $teamRepository
    ) {}

    public function __invoke(GetTeamIdByName $query): string
    {

    }
}
