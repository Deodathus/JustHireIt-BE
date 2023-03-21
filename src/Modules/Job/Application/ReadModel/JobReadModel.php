<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ReadModel;

use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Modules\Job\Domain\ValueObject\CompanyId;

interface JobReadModel
{
    public function fetch(string $id): JobViewModel;

    /**
     * @return JobViewModel[]
     */
    public function fetchByOwnerId(CompanyId $companyId): array;
}
