<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Candidate;

use App\Modules\Candidate\Application\Command\StoreSkillCommand;
use App\Modules\Candidate\Application\CommandHandler\StoreSkillCommandHandler;
use App\Modules\Candidate\Application\DTO\SkillDTO;
use App\Modules\Candidate\Infrastructure\Repository\SkillRepository as SkillRepositoryImplementation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SkillService extends WebTestCase
{
    public static function create(string $name = 'CQRS'): string
    {
        /** @var StoreSkillCommandHandler $storeSkillCommandHandler */
        $storeSkillCommandHandler = self::getContainer()->get(StoreSkillCommandHandler::class);

        return ($storeSkillCommandHandler)(new StoreSkillCommand(new SkillDTO($name)));
    }

    public static function existsByName(string $name): bool
    {
        /** @var SkillRepositoryImplementation $skillRepository */
        $skillRepository = self::getContainer()->get(SkillRepositoryImplementation::class);

        return $skillRepository->existsByName($name);
    }
}
