<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class JobPostPropertyDTO
{
    public function __construct(
        public readonly string $type,
        public readonly string $value
    ) {}
}
