<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\Command;

use App\Modules\Candidate\Application\DTO\SkillDTO;
use App\Shared\Application\Messenger\Command;

final class StoreSkillCommand implements Command
{
    public function __construct(
        public readonly SkillDTO $skill
    ) {}
}
