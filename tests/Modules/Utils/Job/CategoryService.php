<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Job;

use App\Modules\Job\Application\Command\StoreCategoryCommand;
use App\Modules\Job\Application\CommandHandler\StoreCategoryCommandHandler;
use App\Modules\Job\Application\DTO\JobCategoryDTO;
use App\Modules\Job\Application\Exception\JobCategoryNameAlreadyTaken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CategoryService extends WebTestCase
{
    /**
     * @throws JobCategoryNameAlreadyTaken
     */
    public static function create(string $name = 'Test'): string
    {
        /** @var StoreCategoryCommandHandler $storeCategoryHandler */
        $storeCategoryHandler = self::getContainer()->get(StoreCategoryCommandHandler::class);

        return ($storeCategoryHandler)(new StoreCategoryCommand(
            new JobCategoryDTO(
                $name
            )
        ));
    }
}
