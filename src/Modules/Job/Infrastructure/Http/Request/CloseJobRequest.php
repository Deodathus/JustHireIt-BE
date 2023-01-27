<?php

declare(strict_types=1);

namespace App\Modules\Job\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CloseJobRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $jobId,
        public readonly string $token
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $jobId = $request->attributes->get('jobId');
        $token = $request->headers->get('X-Auth-Token');

        Assert::lazy()
            ->that($jobId, 'jobId')->uuid()->notEmpty()->maxLength(255)
            ->that($token, 'token')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self($jobId, $token);
    }

    public function toArray(): array
    {
        return [
            'jobId' => $this->jobId,
            'token' => $this->token,
        ];
    }
}
