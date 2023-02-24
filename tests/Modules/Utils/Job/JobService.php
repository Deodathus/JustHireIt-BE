<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Job;

use App\Modules\Job\Application\Command\StoreJobCommand;
use App\Modules\Job\Application\CommandHandler\StoreJobCommandHandler;
use App\Modules\Job\Application\DTO\JobDTO;
use App\Modules\Job\Application\Exception\JobCategoryDoesNotExist;
use App\Modules\Job\Application\Exception\JobOwnerDoesNotExist;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class JobService extends WebTestCase
{
    /**
     * @throws JobCategoryDoesNotExist
     * @throws JobOwnerDoesNotExist|\App\Modules\Job\Application\Exception\JobCategoryNameAlreadyTaken
     */
    public static function createJob(string $apiToken): string
    {
        CompanyService::create($apiToken);
        $categoryId = CategoryService::create();

        /** @var StoreJobCommandHandler $storeJobCommandHandler */
        $storeJobCommandHandler = self::getContainer()->get(StoreJobCommandHandler::class);
        return ($storeJobCommandHandler)(new StoreJobCommand(
            new JobDTO(
                $categoryId,
                'Test',
                $apiToken,
                []
            )
        ));
    }
}
