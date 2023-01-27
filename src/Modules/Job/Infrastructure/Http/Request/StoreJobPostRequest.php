<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreJobPostRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobId,
        public readonly string $name,
        public readonly array $properties,
        public readonly array $requirements
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $jobId = $request->attributes->get('jobId');
        $name = $requestStack['name'] ?? null;
        $properties = $requestStack['properties'] ?? null;
        $requirements = $requestStack['requirements'] ?? null;

        Assert::lazy()
            ->that($jobId, 'jobId')->uuid()->notEmpty()->maxLength(255)
            ->that($name, 'name')->string()->notEmpty()->maxLength(255)
            ->that($properties, 'properties')->isArray()->isArray()
            ->that($requirements, 'requirements')->isArray()->isArray()
            ->verifyNow();

        foreach ($properties as $property) {
            $type = $property['type'] ?? null;
            $value = $property['value'] ?? null;

            Assert::lazy()
                ->that($type, 'propertyType')->string()->notEmpty()->maxLength(255)
                ->that($value, 'propertyValue')->string()->notEmpty()->maxLength(255)
                ->verifyNow();
        }

        foreach ($requirements as $requirement) {
            $id = $requirement['id'];

            Assert::lazy()
                ->that($id, 'requirementId')->string()->notEmpty()->maxLength(255)
                ->verifyNow();
        }

        return new self(
            $jobId,
            $name,
            $properties,
            $requirements
        );
    }

    public function toArray(): array
    {
        return [
            'jobId' => $this->jobId,
            'name' => $this->name,
            'properties' => $this->properties,
            'requirements' => $this->requirements,
        ];
    }
}
