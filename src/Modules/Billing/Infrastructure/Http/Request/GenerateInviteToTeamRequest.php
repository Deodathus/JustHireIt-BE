<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GenerateInviteToTeamRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $creatorApiToken,
        public readonly string $teamId
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $creatorApiToken = $request->headers->get('X-Auth-Token');
        $teamId = $request->attributes->get('teamId');

        Assert::lazy()
            ->that($creatorApiToken, 'apiToken')->string()->notEmpty()->maxLength(255)
            ->that($teamId, 'teamId')->uuid()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self(
            $creatorApiToken,
            $teamId
        );
    }

    public function toArray(): array
    {
        return [
            'creatorApiToken' => $this->creatorApiToken,
            'teamId' => $this->teamId,
        ];
    }
}
