<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\DTO;

final class ApplicationDTO
{
    public function __construct(
        public readonly string $jobPostId,
        public readonly string $applicantId,
        public readonly string $introduction,
        public readonly bool $byGuest
    ) {}
}
