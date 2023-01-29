<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Search;

final class Filter
{
    public function __construct(
        public readonly string $skillId,
        public readonly int $skillScore
    ) {}
}
