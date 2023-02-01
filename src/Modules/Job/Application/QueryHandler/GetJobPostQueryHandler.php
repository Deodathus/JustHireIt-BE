<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\QueryHandler;

use App\Modules\Job\Application\Query\GetJobPostQuery;
use App\Modules\Job\Application\ReadModel\JobPostReadModel;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;
use App\Shared\Application\Messenger\QueryHandler;

final class GetJobPostQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly JobPostReadModel $readModel
    ) {}

    public function __invoke(GetJobPostQuery $query): JobPostViewModel
    {
        return $this->readModel->fetch($query->jobId, $query->jobPostId);
    }
}
