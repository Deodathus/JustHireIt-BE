<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\Job;

interface JobRepository
{
    public function store(Job $job): void;
}
