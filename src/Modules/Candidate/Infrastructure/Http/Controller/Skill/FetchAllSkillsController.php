<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Controller\Skill;

use App\Modules\Candidate\Application\Query\FetchAllSkillsQuery;
use App\Shared\Application\Messenger\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;

final class FetchAllSkillsController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {}

    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'skills' => $this->queryBus->handle(
                    new FetchAllSkillsQuery()
                ),
            ]
        );
    }
}
