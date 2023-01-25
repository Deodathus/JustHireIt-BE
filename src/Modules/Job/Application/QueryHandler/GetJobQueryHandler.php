<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\QueryHandler;

use App\Modules\Job\Application\Query\GetJobQuery;
use App\Modules\Job\Application\ReadModel\JobReadModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class GetJobQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly JobReadModel $jobReadModel
    ) {}

    public function __invoke(GetJobQuery $query): JobViewModel
    {
        return $this->jobReadModel->fetch($query->jobId);
    }
}
