<?php

declare(strict_types=1);

namespace App\Tests\Modules\Job\Utils;

use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\Service\ApplicationApplier;

final class ApplicationApplierStub implements ApplicationApplier
{
    public function apply(Application $application): void
    {
    }
}
