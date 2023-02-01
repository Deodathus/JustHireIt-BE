<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\QueryHandler;

use App\Modules\Job\Application\Query\GetJobPostsQuery;
use App\Modules\Job\Application\ReadModel\JobPostReadModel;
use App\Modules\Job\Application\Search\SearchQuery;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class GetJobPostsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly JobPostReadModel $readModel
    ) {}

    /**
     * @return JobPostViewModel[]
     */
    public function __invoke(GetJobPostsQuery $query): array
    {
        return $this->readModel->fetchAll(
            new SearchQuery(
                $query->page,
                $query->perPage,
                $query->category
            )
        );
    }
}
