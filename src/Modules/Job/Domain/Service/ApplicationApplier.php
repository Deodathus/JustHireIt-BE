<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Service;

use App\Modules\Job\Domain\Entity\Application;

interface ApplicationApplier
{
    public function apply(Application $application): void;
}
