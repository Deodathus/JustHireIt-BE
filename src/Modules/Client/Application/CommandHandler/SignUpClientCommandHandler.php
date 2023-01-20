<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\CommandHandler;

use App\Modules\Client\Application\Command\SignUpClientCommand;
use App\Modules\Client\Application\DTO\ClientApiTokenDTO;
use App\Modules\Client\Application\Exception\ClientSignUpException;
use App\Modules\Client\Domain\Exception\LoginWasTakenException;
use App\Modules\Client\Domain\Service\ClientSignUpperInterface;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Shared\Application\Api\Service\ApiTokenGeneratorInterface;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Password\DTO\RawPassword;
use App\Shared\Application\Service\PasswordHasherInterface;

final class SignUpClientCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ApiTokenGeneratorInterface $apiTokenGenerator,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly ClientSignUpperInterface $signUpper
    ) {}

    /**
     * @throws ClientSignUpException
     */
    public function __invoke(SignUpClientCommand $command): ClientApiTokenDTO
    {
        $id = ClientId::generate();
        $hashedPassword = $this->passwordHasher->hash(new RawPassword($command->clientDTO->password));
        $apiToken = $this->apiTokenGenerator->generate($id, $hashedPassword->salt);

        try {
            $this->signUpper->signUp(
                $id,
                $command->clientDTO->login,
                $hashedPassword,
                $apiToken,
                $command->clientDTO->email,
                $command->clientDTO->companyName
            );
        } catch (LoginWasTakenException $exception) {
            throw ClientSignUpException::fromPrevious($exception);
        }

        return new ClientApiTokenDTO(
            $apiToken->value()
        );
    }
}
