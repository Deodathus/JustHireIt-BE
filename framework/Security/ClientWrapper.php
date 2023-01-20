<?php

declare(strict_types=1);

namespace Framework\Security;

use App\Modules\Client\Domain\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

final class ClientWrapper implements UserInterface
{
    private function __construct(
        private readonly string $id,
        private readonly string $login,
        private readonly string $apiToken
    ) {}

    public static function createFromClient(Client $user): self
    {
        return new self(
            $user->getId()->toString(),
            $user->getLogin(),
            $user->getApiToken()
        );
    }

    public function getRoles(): array
    {
        return [
            'client',
        ];
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->apiToken;
    }
}
