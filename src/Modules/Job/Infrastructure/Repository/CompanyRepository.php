<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Repository;

use App\Modules\Job\Application\Exception\CompanyDoesNotExist;
use App\Modules\Job\Domain\Entity\Company;
use App\Modules\Job\Domain\Repository\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Job\Domain\ValueObject\CompanyId;
use App\Modules\Job\Domain\ValueObject\OwnerId;
use Doctrine\DBAL\Connection;

final class CompanyRepository implements CompanyRepositoryInterface
{
    private const DB_TABLE_NAME = 'companies';

    public function __construct(
        private readonly Connection $connection
    ) {}

    public function fetchCompanyIdByOwner(OwnerId $ownerId): CompanyId
    {
        $companyId = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from(self::DB_TABLE_NAME)
            ->where('owner_id = :ownerId')
            ->setParameter('ownerId', $ownerId->toString())
            ->fetchOne();

        if (!$companyId) {
            throw CompanyDoesNotExist::withOwnerId($ownerId->toString());
        }

        return CompanyId::fromString($companyId);
    }

    public function store(Company $company): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DB_TABLE_NAME)
            ->values([
                'id' => ':id',
                'owner_id' => ':ownerId',
                'name' => ':name',
                'description' => ':description',
            ])
            ->setParameters([
                'id' => $company->getId()->toString(),
                'ownerId' => $company->getOwnerId()->toString(),
                'name' => $company->getName(),
                'description' => $company->getDescription(),
            ])
            ->executeStatement();
    }

    public function existsByName(string $name): bool
    {
        $found = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from(self::DB_TABLE_NAME)
            ->where('name = :name')
            ->setParameter('name', $name)
            ->fetchAllAssociative();

        return count($found) > 0;
    }
}
