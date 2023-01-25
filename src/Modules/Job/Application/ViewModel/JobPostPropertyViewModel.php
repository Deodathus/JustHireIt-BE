<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\ViewModel;

final class JobPostPropertyViewModel
{
    public function __construct(
        public readonly string $type,
        public readonly string $value
    ) {}
}
