<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class SearchCandidatesRequest extends AbstractRequest
{
    private function __construct(
        public readonly int $perPage,
        public readonly int $page,
        public readonly array $filters
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $filters = $requestStack['filters'] ?? null;
        $perPage = $requestStack['perPage'] ?? 20;
        $page = $requestStack['page'] ?? null;

        Assert::lazy()
            ->that($filters, 'filters')->isArray()->notEmpty()->keyExists('mustHave')
            ->that($perPage, 'perPage')->numeric()->min(10)->max(50)
            ->that($page, 'page')->numeric()->min(1)
            ->verifyNow();

        $mustHaves = $filters['mustHave'] ?? null;
        foreach ($mustHaves as $mustHave) {
            $skillId = array_keys($mustHave)[0];
            $skillScore = $mustHave[$skillId];

            Assert::lazy()
                ->that($skillId, 'skillId')->uuid()->notEmpty()
                ->that($skillScore, 'skillScore')->numeric()->notNull()->max(10)->min(1)
                ->verifyNow();
        }

        return new self($perPage, $page, $filters);
    }

    public function toArray(): array
    {
        return [
            'perPage' => $this->perPage,
            'page' => $this->page,
            'filters' => $this->filters,
        ];
    }
}
