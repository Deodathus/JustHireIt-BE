<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Domain\Entity;

use App\Modules\Authentication\Domain\ValueObject\UserId;
use App\Shared\Domain\ValueObject\Password;

class User
{
    public function __construct(
        private readonly UserId $id,
        private readonly string $email,
        private readonly string $login,
        private readonly Password $password,
        private readonly string $apiToken
    ) {}

    public static function create(string $login, Password $password, string $apiToken, string $email): self
    {
        $id = UserId::generate();

        return new User(
            $id,
            $email,
            $login,
            $password,
            $apiToken
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

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return (string) $this->password->salt;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }
}
