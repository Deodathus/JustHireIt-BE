<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreJobRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $name,
        public readonly string $ownerToken,
        public readonly array $jobPosts
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $name = $requestStack['name'] ?? null;
        $ownerToken = $request->headers->get('X-Auth-Token');
        $jobPosts = $requestStack['jobPosts'];

        Assert::lazy()
            ->that($name, 'name')->string()->notEmpty()->maxLength(255)
            ->that($ownerToken, 'token')->string()->notEmpty()->maxLength(255)
            ->that($jobPosts, 'jobPosts')->isArray()->notEmpty()
            ->verifyNow();

        foreach ($jobPosts as $jobPost) {
            $name = $jobPost['name'] ?? null;
            $properties = $jobPost['properties'] ?? null;

            Assert::lazy()
                ->that($name, 'name')->string()->notEmpty()->maxLength(255)
                ->that($properties, 'properties')->isArray()->isArray()
                ->verifyNow();

            foreach ($jobPost['properties'] as $jobPostProperty) {
                $type = $jobPostProperty['type'] ?? null;
                $value = $jobPostProperty['value'] ?? null;

                Assert::lazy()
                    ->that($type, 'type')->string()->notEmpty()->maxLength(255)
                    ->that($value, 'value')->string()->notEmpty()->maxLength(255)
                    ->verifyNow();
            }
        }

        return new self(
            $name,
            $ownerToken,
            $jobPosts
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'ownerToken' => $this->ownerToken,
            'jobPosts' => $this->jobPosts,
        ];
    }
}
