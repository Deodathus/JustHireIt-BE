<?php

declare(strict_types=1);

namespace App\Modules\Billing\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class AcceptInviteToTeamRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $teamId,
        public readonly string $invitationId,
        public readonly string $email,
        public readonly string $login,
        public readonly string $password
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $teamId = $request->attributes->get('teamId');
        $invitationId = $request->attributes->get('invitationId');
        $email = $requestStack['email'] ?? null;
        $login = $requestStack['login'] ?? null;
        $password = $requestStack['password'] ?? null;

        Assert::lazy()
            ->that($teamId, 'teamId')->uuid()->notEmpty()->maxLength(255)
            ->that($invitationId, 'invitationId')->uuid()->notEmpty()->maxLength(255)
            ->that($email, 'email')->email()->notEmpty()->maxLength(255)
            ->that($login, 'login')->string()->notEmpty()->maxLength(255)
            ->that($password, 'password')->string()->notEmpty()->maxLength(255)
            ->verifyNow();

        return new self(
            $teamId,
            $invitationId,
            $email,
            $login,
            $password
        );
    }

    public function toArray(): array
    {
        return [
            'teamId' => $this->teamId,
            'invitationId' => $this->invitationId,
        ];
    }
}
