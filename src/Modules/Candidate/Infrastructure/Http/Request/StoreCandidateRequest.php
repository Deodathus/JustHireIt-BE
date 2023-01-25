<?php

declare(strict_types=1);

namespace App\Modules\Candidate\Infrastructure\Http\Request;

use App\SharedInfrastructure\Http\Request\AbstractRequest;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class StoreCandidateRequest extends AbstractRequest
{
    private function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly array $skills
    ) {}

    public static function fromRequest(ServerRequest $request): AbstractRequest
    {
        $requestStack = $request->toArray();

        $firstName = $requestStack['firstName'] ?? null;
        $lastName = $requestStack['lastName'] ?? null;
        $skills = $requestStack['skills'] ?? null;

        Assert::lazy()
            ->that($firstName, 'firstName')->string()->notEmpty()->maxLength(255)
            ->that($lastName, 'lastName')->string()->notEmpty()->maxLength(255)
            ->that($skills, 'skills')->isArray()->notEmpty()
            ->verifyNow();

        $encodedSkills = [];
        foreach ($skills as $skill) {
            $id = $skill['id'] ?? null;
            $name = $skill['name'] ?? null;
            $score = $skill['score'] ?? null;
            $numericScore = $skill['numericScore'] ?? null;

            $encodedScore = json_encode($score);

            Assert::lazy()
                ->that($id, 'id')->string()->notEmpty()->maxLength(255)
                ->that($name, 'name')->string()->notEmpty()->maxLength(255)
                ->that($encodedScore, 'score')->string()->notEmpty()->maxLength(255)
                ->that($numericScore, 'numericScore')->numeric()->notNull()->max(10)
                ->verifyNow();

            $encodedSkills[] = [
                'id' => $id,
                'name' => $name,
                'score' => $encodedScore,
                'numericScore' => $numericScore,
            ];
        }

        return new self($firstName, $lastName, $encodedSkills);
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'skills' => $this->skills,
        ];
    }
}
