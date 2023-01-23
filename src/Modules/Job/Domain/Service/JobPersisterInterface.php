<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Entity\Job;

interface JobPersisterInterface
{
    public function store(Job $job): void;
}
