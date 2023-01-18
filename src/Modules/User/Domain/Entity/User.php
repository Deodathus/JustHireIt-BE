<?php

declare(strict_types=1);

namespace App\Modules\User\Domain\Entity;

use App\Modules\User\Domain\ValueObject\UserId;

class User
{
    public function __construct(
        private readonly UserId $id,
        private readonly string $email,
        private readonly string $login,
        private readonly string $password,
        private readonly string $salt,
        private readonly string $apiToken
    ) {}

    public static function generate(): self
    {
        $id = UserId::generate();

        return new User(
            $id,
            sprintf('%s@example.com', $id->toString()),
            $id->toString(),
            $id->toString(),
            UserId::generate()->toString(),
            UserId::generate()->toString()
        );
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return $this->salt;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }
}
