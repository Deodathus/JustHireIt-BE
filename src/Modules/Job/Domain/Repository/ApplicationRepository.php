<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\Application;

interface ApplicationRepository
{
    public function store(Application $application): void;
}
