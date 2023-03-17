<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Job;

use App\Modules\Job\Application\Command\StoreCompanyCommand;
use App\Modules\Job\Application\CommandHandler\StoreCompanyCommandHandler;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use App\Modules\Job\Infrastructure\Repository\CompanyRepository as CompanyRepositoryImplementation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CompanyService extends WebTestCase
{
    public static function existsByName(string $name): bool
    {
        /** @var CompanyRepositoryImplementation $companyRepository */
        $companyRepository = self::getContainer()->get(CompanyRepositoryImplementation::class);

        return $companyRepository->existsByName($name);
    }

    /**
     * @throws JobOwnerDoesNotExist
     */
    public static function create(string $apiToken, string $name = 'Test', string $description = 'Test'): string
    {
        /** @var StoreCompanyCommandHandler $storeCompanyCommandHandler */
        $storeCompanyCommandHandler = self::getContainer()->get(StoreCompanyCommandHandler::class);

        return ($storeCompanyCommandHandler)(new StoreCompanyCommand($apiToken, $name, $description));
    }
}
