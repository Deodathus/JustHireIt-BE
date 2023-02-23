<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\QueryHandler;

use App\Modules\Job\Application\Query\GetJobCategoriesQuery;
use App\Modules\Job\Application\ReadModel\JobCategoryReadModel;
use App\Modules\Job\Application\ViewModel\JobCategoryViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class GetJobCategoriesQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly JobCategoryReadModel $readModel
    ) {}

    /**
     * @return JobCategoryViewModel[]
     */
    public function __invoke(GetJobCategoriesQuery $query): array
    {
        return $this->readModel->fetchAll();
    }
}
