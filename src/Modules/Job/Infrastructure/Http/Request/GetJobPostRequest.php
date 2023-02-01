<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetJobPostRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobId,
        public readonly string $jobPostId
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $jobId = $request->attributes->get('jobId');
        $jobPostId = $request->attributes->get('jobPostId');

        Assert::lazy()
            ->that($jobPostId, 'jobPostId')->uuid()->notEmpty()->maxLength(255)
            ->that($jobId, 'jobId')->uuid()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($jobId, $jobPostId);
    }

    public function toArray(): array
    {
        return [
            'jobId' => $this->jobId,
            'jobPostId' => $this->jobPostId,
        ];
    }
}
