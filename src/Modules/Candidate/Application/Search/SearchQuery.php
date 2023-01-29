<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Search;

final class SearchQuery
{
    public function __construct(
        public readonly int $perPage,
        public readonly int $page,
        public readonly MustHaves $mustHaves
    ) {}
}
