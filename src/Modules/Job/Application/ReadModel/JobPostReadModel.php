<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ReadModel;

use App\Modules\Job\Application\Search\SearchQuery;
use App\Modules\Job\Application\ViewModel\JobPostViewModel;

interface JobPostReadModel
{
    public function fetch(string $jobId, string $jobPostId): JobPostViewModel;

    /**
     * @return JobPostViewModel[]
     */
    public function fetchAll(SearchQuery $searchQuery): array;
}
