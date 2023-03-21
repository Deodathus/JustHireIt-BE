<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\QueryHandler;

use App\Modules\Candidate\Application\Query\FetchAllSkillsQuery;
use App\Modules\Candidate\Application\ReadModel\SkillReadModel;
use App\Modules\Candidate\Application\ViewModel\SkillViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class FetchAllSkillsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly SkillReadModel $skillReadModel
    ) {}

    /**
     * @return SkillViewModel[]
     */
    public function __invoke(FetchAllSkillsQuery $query): array
    {
        return $this->skillReadModel->fetchAll();
    }
}
