<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\ReadModel;

use App\Modules\Candidate\Application\ViewModel\SkillViewModel;

interface SkillReadModel
{
    /**
     * @return SkillViewModel[]
     */
    public function fetchAll(): array;
}
