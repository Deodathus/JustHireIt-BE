<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Modules\Job\Application\ReadModel\JobReadModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Tests\Modules\Job\Utils\Mother\JobViewModelMother;

final class JobReadModelFake implements JobReadModel
{
    public function fetch(string $id): JobViewModel
    {
        return JobViewModelMother::create($id);
    }

    public function fetchByOwnerId(CompanyId $companyId): array
    {
        return [];
    }
}
