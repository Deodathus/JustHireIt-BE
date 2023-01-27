<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Command;

use App\Modules\Job\Application\DTO\JobCategoryDTO;
use App\Shared\Application\Messenger\Command;

final class StoreCategoryCommand implements Command
{
    public function __construct(
        public readonly JobCategoryDTO $jobCategory
    ) {}
}
