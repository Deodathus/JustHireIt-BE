<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Application\QueryHandler;

use App\Modules\Candidate\Domain\Repository\SkillRepository;
use App\Modules\Candidate\Domain\ValueObject\SkillId;
use App\Modules\Candidate\ModuleApi\Application\Query\SkillByIdExistsQuery;
use App\Shared\Application\Messenger\QueryHandler;

final class SkillByIdExistsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly SkillRepository $skillRepository
    ) {}

    public function __invoke(SkillByIdExistsQuery $query): bool
    {
        return $this->skillRepository->exists(SkillId::fromString($query->id));
    }
}
