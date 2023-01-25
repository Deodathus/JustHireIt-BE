<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Service;

use App\Modules\Job\Domain\Entity\Application;
use App\Modules\Job\Domain\Repository\ApplicationRepository;
use App\Modules\Job\Domain\Service\ApplicationApplier as ApplicationApplierInterface;

final class ApplicationApplier implements ApplicationApplierInterface
{
    public function __construct(
        private readonly ApplicationRepository $repository
    ) {}

    public function apply(Application $application): void
    {
        $this->repository->store($application);
    }
}
