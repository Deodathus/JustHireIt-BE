<?php

declare(strict_types=1);

namespace App\Tests\Modules\Candidate\Application;

use App\Modules\Candidate\Application\Command\StoreSkillCommand;
use App\Modules\Candidate\Application\CommandHandler\StoreSkillCommandHandler;
use App\Modules\Candidate\Application\DTO\SkillDTO;
use App\Tests\Modules\Candidate\Util\SkillPersisterStub;
use App\Tests\Modules\Candidate\Util\SkillRepositorySpy;
use PHPUnit\Framework\TestCase;

final class StoreSkillCommandHandlerTest extends TestCase
{
    private const SKILL_NAME = 'CQRS';

    /** @test */
    public function shouldStoreSkill(): void
    {
        $skillRepository = new SkillRepositorySpy();
        $sut = new StoreSkillCommandHandler(
            new SkillPersisterStub($skillRepository)
        );

        $skillId = ($sut)(new StoreSkillCommand(new SkillDTO(self::SKILL_NAME)));

        $this->assertIsString($skillId);
        $this->assertTrue($skillRepository->existsByName(self::SKILL_NAME));
    }
}
