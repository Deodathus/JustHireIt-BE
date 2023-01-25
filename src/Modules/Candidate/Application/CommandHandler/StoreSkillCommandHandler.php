<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\CommandHandler;

use App\Modules\Candidate\Application\Command\StoreSkillCommand;
use App\Modules\Candidate\Domain\Entity\Skill;
use App\Modules\Candidate\Domain\Service\SkillPersister;
use App\Modules\Candidate\Domain\ValueObject\SkillId;
use App\Shared\Application\Messenger\CommandHandler;

final class StoreSkillCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly SkillPersister $skillPersister
    ) {}

    public function __invoke(StoreSkillCommand $storeSkillCommand): string
    {
        $id = SkillId::generate();

        $this->skillPersister->store(
            new Skill(
                $id,
                $storeSkillCommand->skill->name
            )
        );

        return $id->toString();
    }
}
