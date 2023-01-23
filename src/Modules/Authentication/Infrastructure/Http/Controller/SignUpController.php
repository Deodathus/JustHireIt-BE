<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Infrastructure\Http\Controller;

use App\Modules\Authentication\Application\Command\SignUpUserCommand;
use App\Modules\Authentication\Application\DTO\UserDTO;
use App\Modules\Authentication\Infrastructure\Http\Request\SignUpRequest;
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
