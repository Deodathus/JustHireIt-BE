<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\CommandHandler;

use App\Modules\Authentication\Application\Command\SignUpUserCommand;
use App\Modules\Authentication\Application\DTO\UserApiTokenDTO;
use App\Modules\Authentication\Application\Exception\UserSignUpException;
use App\Modules\Authentication\Domain\Exception\LoginWasTakenException;
use App\Modules\Authentication\Domain\Service\UserSignUpperInterface;
use App\Modules\Authentication\Domain\ValueObject\UserId;
use App\Shared\Application\Api\Service\ApiTokenGeneratorInterface;
use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Password\DTO\RawPassword;
use App\Shared\Application\Service\PasswordHasherInterface;

final class SignUpUserCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly UserSignUpperInterface $signUpper,
        private readonly ApiTokenGeneratorInterface $apiTokenGenerator,
        private readonly PasswordHasherInterface $passwordHasher
    ) {}

    /**
     * @throws UserSignUpException
     */
    public function __invoke(SignUpUserCommand $command): UserApiTokenDTO
    {
        $id = UserId::generate();
        $hashedPassword = $this->passwordHasher->hash(
            new RawPassword($command->userDTO->password)
        );
        $apiToken = $this->apiTokenGenerator->generate(
            $id,
            $hashedPassword->salt
        );

        try {
            $this->signUpper->signUp(
                $id,
                $command->userDTO->login,
                $hashedPassword,
                $apiToken,
                $command->userDTO->email
            );
        } catch (LoginWasTakenException $exception) {
            throw UserSignUpException::fromPrevious($exception);
        }

        return new UserApiTokenDTO(
            $apiToken->value()
        );
    }
}
