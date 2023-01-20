<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class LoginRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $login,
        public readonly string $rawPassword
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $login = $requestStack['login'] ?? null;
        $rawPassword = $requestStack['password'] ?? null;

        Assert::lazy()
            ->that($login)->string()->notEmpty()->maxLength(255)
            ->that($rawPassword)->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self(
            $login,
            $rawPassword
        );
    }

    public function toArray(): array
    {
        return [
            'login' => $this->login,
            'rawPassword' => $this->rawPassword,
        ];
    }
}
