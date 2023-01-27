<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CloseJobPostRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobPostId,
        public readonly string $jobId,
        public readonly string $token
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $jobPostId = $request->attributes->get('jobPostId');
        $jobId = $request->attributes->get('jobId');
        $token = $request->headers->get('X-Auth-Token');

        Assert::lazy()
            ->that($jobPostId, 'jobPostId')->uuid()->notEmpty()->maxLength(255)
            ->that($jobId, 'jobId')->uuid()->notEmpty()->maxLength(255)
            ->that($token, 'token')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self(
            $jobPostId,
            $jobId,
            $token
        );
    }

    public function toArray(): array
    {
        return [
            'jobPostId' => $this->jobPostId,
            'jobId' => $this->jobId,
            'token' => $this->token,
        ];
    }
}
