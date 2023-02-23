<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ReadModel;

use App\Modules\Job\Application\ViewModel\JobCategoryViewModel;

interface JobCategoryReadModel
{
    /**
     * @return JobCategoryViewModel[]
     */
    public function fetchAll(): array;
}
