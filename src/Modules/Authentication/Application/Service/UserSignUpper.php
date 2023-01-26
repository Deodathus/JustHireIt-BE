<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Application\Service;

use App\Modules\Authentication\Application\DTO\HashedPassword;
use App\Modules\Authentication\Application\Exception\UserSignUpException;
use App\Modules\Authentication\Domain\Entity\User;
use App\Modules\Authentication\Domain\Event\UserSignedUp;
use App\Modules\Authentication\Domain\Exception\LoginWasTakenException;
use App\Modules\Authentication\Domain\Service\UserPersisterInterface;
use App\Modules\Authentication\Domain\Service\UserSignUpperInterface;
use App\Modules\Authentication\Domain\ValueObject\Password;
use App\Modules\Authentication\Domain\ValueObject\UserId;
use App\Shared\Application\Api\DTO\ApiToken;
use App\Shared\Application\Messenger\EventBus;

final class UserSignUpper implements UserSignUpperInterface
{
    public function __construct(
        private readonly UserPersisterInterface $persister,
        private readonly EventBus $eventBus
    ) {}

    /**
     * @throws UserSignUpException
     */
    public function signUp(UserId $id, string $login, HashedPassword $password, ApiToken $apiToken, string $email): void
    {
        try {
            $this->persister->persist(
                new User(
                    $id,
                    $email,
                    $login,
                    new Password($password->password, $password->salt),
                    $apiToken->value()
                )
            );
        } catch (LoginWasTakenException $exception) {
            throw UserSignUpException::fromPrevious($exception);
        }

        $this->eventBus->dispatch(
            new UserSignedUp($id->toString())
        );
    }
}
