<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\ViewModel;

final class SkillViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $name
    ) {}
}
