<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreSkillRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $name
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $name = $requestStack['name'] ?? null;

        Assert::lazy()
            ->that($name, 'name')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($name);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
