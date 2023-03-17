<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Assert\LazyAssertionException;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class SignUpRequest extends AbstractRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $login,
        public readonly string $rawPassword,
        public readonly string $companyName,
        public readonly string $companyDescription
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        try {
            $requestStack = $request->toArray();
        } catch (JsonException $exception) {
            throw new LazyAssertionException($exception->getMessage(), []);
        }

        $email = $requestStack['email'] ?? null;
        $login = $requestStack['login'] ?? null;
        $rawPassword = $requestStack['password'] ?? null;
        $companyName = $requestStack['companyName'] ?? '';
        $companyDescription = $requestStack['companyDescription'] ?? '';

        Assert::lazy()
            ->that($email, 'email')->string()->notEmpty()->maxLength(255)
            ->that($login, 'login')->string()->notEmpty()->maxLength(255)
            ->that($rawPassword, 'password')->string()->notEmpty()->maxLength(255)
            ->that($companyName, 'companyName')->string()->maxLength(255)
            ->that($companyDescription, 'companyDescription')->string()->maxLength(255)
            ->verifyNow();

        return new self(
            $email,
            $login,
            $rawPassword,
            $companyName,
            $companyDescription
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'login' => $this->login,
            'rawPassword' => $this->rawPassword,
            'companyName' => $this->companyName,
            'companyDescription' => $this->companyDescription,
        ];
    }
}
