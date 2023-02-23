<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Modules\Job\Application\ReadModel\JobReadModel;
use App\Modules\Job\Application\ViewModel\JobViewModel;
use App\Modules\Job\Domain\ValueObject\JobPostId;
use App\Modules\Job\Domain\ValueObject\OwnerId;

final class JobReadModelFake implements JobReadModel
{
    public function fetch(string $id): JobViewModel
    {
        return new JobViewModel(
            JobPostId::generate()->toString(),
            OwnerId::generate()->toString(),
            'Test name',
            []
        );
    }
}
