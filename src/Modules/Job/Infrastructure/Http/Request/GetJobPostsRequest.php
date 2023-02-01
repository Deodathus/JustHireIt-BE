<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetJobPostsRequest extends AbstractRequest
{
    private function __construct(
        public readonly int $perPage,
        public readonly int $page,
        public readonly ?string $category
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->query->all();

        $perPage = $requestStack['perPage'] ?? 20;
        $page = $requestStack['page'] ?? 1;
        $category = $requestStack['category'] ?? null;

        Assert::lazy()
            ->that($perPage, 'perPage')->numeric()->min(10)->max(50)
            ->that($page, 'page')->numeric()->min(1)
            ->that($category, 'category')->nullOr()->string()->maxLength(255)
            ->verifyNow();

        return new self($perPage, $page, $category);
    }

    public function toArray(): array
    {
        return [
            'perPage' => $this->perPage,
            'page' => $this->page,
            'category' => $this->category,
        ];
    }
}
