<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ViewModel;

final class JobCategoryViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {}
}
