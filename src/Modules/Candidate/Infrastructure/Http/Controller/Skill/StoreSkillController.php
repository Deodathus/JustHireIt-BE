<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Controller\Skill;

use App\Modules\Candidate\Application\Command\StoreSkillCommand;
use App\Modules\Candidate\Application\DTO\SkillDTO;
use App\Modules\Candidate\Infrastructure\Http\Request\StoreSkillRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class StoreSkillController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(StoreSkillRequest $request): JsonResponse
    {
        $id = $this->commandBus->dispatch(
            new StoreSkillCommand(new SkillDTO($request->name))
        );

        return new JsonResponse(
            [
                'id' => $id,
            ],
            Response::HTTP_CREATED
        );
    }
}
