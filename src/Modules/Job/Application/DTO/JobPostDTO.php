<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class JobPostDTO
{
    /**
     * @param JobPostPropertyDTO[] $properties
     */
    public function __construct(
        public readonly string $name,
        public readonly array $properties
    ) {}
}
