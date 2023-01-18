<?php

declare(strict_types=1);

namespace Framework\Security;

use App\Modules\User\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserWrapper implements UserInterface
{
    private function __construct(
        private readonly string $id,
        private readonly string $login
    ) {}

    public static function createFromUser(User $user): self
    {
        return new self(
            $user->getId()->toString(),
            $user->getLogin()
        );
    }

    public function getRoles(): array
    {
        return [
            'user',
        ];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }
}
