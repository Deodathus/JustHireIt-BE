<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Entity;

use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Shared\Domain\ValueObject\Password;

class Client
{
    public function __construct(
        private readonly ClientId $id,
        private readonly string $email,
        private readonly string $login,
        private readonly Password $password,
        private readonly string $apiToken
    ) {}

    public static function create(string $login, Password $password, string $apiToken, string $email): self
    {
        $id = ClientId::generate();

        return new Client(
            $id,
            $email,
            $login,
            $password,
            $apiToken
        );
    }

    public function getId(): ClientId
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
        return $this->password->salt;
    }

    public function getApiToken(): string
    {
        return $this->apiToken;
    }
}
