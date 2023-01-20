<?php

declare(strict_types=1);

namespace App\Modules\Client\Infrastructure\Http\Controller;

use App\Modules\Client\Application\Command\SignUpClientCommand;
use App\Modules\Client\Application\DTO\ClientApiTokenDTO;
use App\Modules\Client\Application\DTO\ClientDTO;
use App\Modules\Client\Infrastructure\Http\Request\SignUpRequest;
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
        /** @var ClientApiTokenDTO $apiToken */
        $apiToken = $this->commandBus->dispatch(
            new SignUpClientCommand(
                new ClientDTO(
                    $request->login,
                    $request->rawPassword,
                    $request->email,
                    $request->companyName
                )
            )
        );

        return new JsonResponse(
            [
                'apiToken' => $apiToken->apiToken,
            ],
            Response::HTTP_CREATED
        );
    }
}
