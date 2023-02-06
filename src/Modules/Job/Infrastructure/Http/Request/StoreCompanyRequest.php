<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreCompanyRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $apiToken,
        public readonly string $name,
        public readonly string $description
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $apiToken = $request->headers->get('X-Auth-Token');
        $name = $requestStack['name'] ?? null;
        $description = $requestStack['description'] ?? null;

        Assert::lazy()
            ->that($apiToken, 'apiToken')->string()->notEmpty()->maxLength(255)
            ->that($name, 'name')->string()->notEmpty()->maxLength(255)
            ->that($description, 'description')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($apiToken, $name, $description);
    }

    public function toArray(): array
    {
        return [
            'apiToken' => $this->apiToken,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
