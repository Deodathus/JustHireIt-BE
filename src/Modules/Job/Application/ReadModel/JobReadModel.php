<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ReadModel;

use App\Modules\Job\Application\ViewModel\JobViewModel;

interface JobReadModel
{
    public function fetch(string $id): JobViewModel;
}
