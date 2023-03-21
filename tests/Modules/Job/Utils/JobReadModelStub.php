<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Application\ReadModel\JobReadModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Modules\Job\Domain\ValueObject\CompanyId;

final class JobReadModelStub implements JobReadModel
{
    public function fetch(string $id): JobViewModel
    {
        throw JobNotFound::withId($id);
    }

    public function fetchByOwnerId(CompanyId $companyId): array
    {
        return [];
    }
}
