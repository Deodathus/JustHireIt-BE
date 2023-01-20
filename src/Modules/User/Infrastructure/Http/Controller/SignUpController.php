<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Http\Controller;

use App\Modules\User\Application\Command\SignUpUserCommand;
use App\Modules\User\Application\DTO\UserDTO;
use App\Modules\User\Infrastructure\Http\Request\SignUpRequest;
use App\Shared\Application\Messenger\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SignUpController
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {}

    public function __invoke(SignUpRequest $request): JsonResponse
    {
        $apiToken = $this->commandBus->dispatch(
            new SignUpUserCommand(
                new UserDTO(
                    $request->login,
                    $request->rawPassword,
                    $request->email
                )
            )
        );

        return new JsonResponse(
            [
                'apiToken' => $apiToken,
            ],
            Response::HTTP_CREATED
        );
    }
}
