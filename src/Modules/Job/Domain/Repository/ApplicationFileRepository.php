<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\ApplicationFile;

interface ApplicationFileRepository
{
    public function store(ApplicationFile $applicationFile): void;
}
