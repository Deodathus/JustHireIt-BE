<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\Job;

use App\Modules\Job\Application\Command\StoreJobPostCommand;
use App\Modules\Job\Application\CommandHandler\StoreJobPostCommandHandler;
use App\Modules\Job\Application\DTO\JobPostDTO;
use App\Modules\Job\Application\DTO\JobPostPropertyDTO;
use App\Modules\Job\Application\DTO\JobPostRequirementDTO;
use App\Modules\Job\Application\Exception\JobNotFound;
use App\Modules\Job\Domain\Enum\JobPostPropertyTypes;
use App\Tests\Modules\Utils\Candidate\SkillService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class JobPostService extends WebTestCase
{
    /**
     * @throws JobNotFound
     */
    public static function createJobPost(string $jobId, string $name = 'Test'): string
    {
        $skillId = SkillService::create();

        /** @var StoreJobPostCommandHandler $storeJobPostCommandHandler */
        $storeJobPostCommandHandler = self::getContainer()->get(StoreJobPostCommandHandler::class);

        return ($storeJobPostCommandHandler)(
            new StoreJobPostCommand(
                $jobId,
                new JobPostDTO(
                    $name,
                    [
                        new JobPostPropertyDTO(JobPostPropertyTypes::DESCRIPTION->name, 'Test description',)
                    ],
                    [
                        new JobPostRequirementDTO($skillId, rand(1, 5))
                    ]
                )
            )
        );
    }
}
