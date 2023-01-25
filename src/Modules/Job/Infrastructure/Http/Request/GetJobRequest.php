<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetJobRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobId
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $jobId = $request->attributes->get('jobId');

        Assert::lazy()
            ->that($jobId, 'jobId')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($jobId);
    }

    public function toArray(): array
    {
        return [
            'jobId' => $this->jobId,
        ];
    }
}
