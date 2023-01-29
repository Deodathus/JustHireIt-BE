<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Search;

final class MustHaves
{
    /**
     * @param Filter[] $filters
     */
    public function __construct(
        public readonly array $filters
    ) {}
}
