<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Entity\ApplicationFile;

interface ApplicationFilePersister
{
    public function store(ApplicationFile $applicationFile): void;
}
