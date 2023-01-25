<?php

declare(strict_types=1);

namespace App\Modules\Candidate\ModuleApi\Application\Query;

use App\Shared\Application\Messenger\Query;

final class SkillByIdExistsQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {}
}
