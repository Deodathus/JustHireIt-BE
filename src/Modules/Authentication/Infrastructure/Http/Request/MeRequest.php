<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class MeRequest extends AbstractRequest
{
    private const TOKEN_HEADER = 'X-Auth-Token';

    private function __construct(
        public readonly string $token
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $token = $request->headers->get(self::TOKEN_HEADER);

        Assert::lazy()
            ->that($token, 'token')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($token);
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
