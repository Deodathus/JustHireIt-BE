<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Repository;

use App\Modules\Job\Domain\Entity\Company;
use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;

interface CompanyRepository
{
    public function store(Company $company): void;
    public function fetchCompanyIdByOwner(OwnerId $ownerId): CompanyId;

    public function existsByName(string $name): bool;
}
