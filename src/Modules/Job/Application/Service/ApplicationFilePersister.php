<?php

declare(strict_types=1);

namespace App\Modules\Job\Application\Service;

use App\Modules\Job\Domain\Entity\ApplicationFile;
use App\Modules\Job\Domain\Repository\ApplicationFileRepository;
use App\Modules\Job\Domain\Service\ApplicationFilePersister as ApplicationFilePersisterInterface;

final class ApplicationFilePersister implements ApplicationFilePersisterInterface
{
    public function __construct(
        private readonly ApplicationFileRepository $repository
    ) {}

    public function store(ApplicationFile $applicationFile): void
    {
        $this->repository->store($applicationFile);
    }
}
