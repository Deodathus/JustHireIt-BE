<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreJobRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $categoryId,
        public readonly string $name,
        public readonly string $ownerToken,
        public readonly array $jobPosts
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $categoryId = $requestStack['categoryId'] ?? null;
        $name = $requestStack['name'] ?? null;
        $ownerToken = $request->headers->get('X-Auth-Token');
        $jobPosts = $requestStack['jobPosts'] ?? [];

        Assert::lazy()
            ->that($categoryId,'categoryId')->uuid()->notEmpty()->maxLength(255)
            ->that($name, 'name')->string()->notEmpty()->maxLength(255)
            ->that($ownerToken, 'token')->string()->notEmpty()->maxLength(255)
            ->that($jobPosts, 'jobPosts')->isArray()
            ->verifyNow();

        if (!empty($jobPosts)) {
            foreach ($jobPosts as $jobPost) {
                $jobPostName = $jobPost['name'] ?? null;
                $properties = $jobPost['properties'] ?? null;
                $requirements = $jobPost['requirements'] ?? null;

                Assert::lazy()
                    ->that($jobPostName, 'jobPostName')->string()->notEmpty()->maxLength(255)
                    ->that($properties, 'properties')->isArray()->isArray()
                    ->that($requirements, 'requirements')->isArray()->isArray()
                    ->verifyNow();

                foreach ($jobPost['properties'] as $jobPostProperty) {
                    $type = $jobPostProperty['type'] ?? null;
                    $value = $jobPostProperty['value'] ?? null;

                    Assert::lazy()
                        ->that($type, 'propertyType')->string()->notEmpty()->maxLength(255)
                        ->that($value, 'propertyValue')->string()->notEmpty()->maxLength(255)
                        ->verifyNow();
                }

                foreach ($jobPost['requirements'] as $requirement) {
                    $id = $requirement['id'];
                    $score = $requirement['score'];

                    Assert::lazy()
                        ->that($id, 'requirementId')->string()->notEmpty()->maxLength(255)
                        ->that($score, 'score')->numeric()->min(1)->max(5)->notNull()
                        ->verifyNow();
                }
            }
        }

        return new self(
            $categoryId,
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
