<?php

declare(strict_types=1);

namespace App\Tests\Modules\Candidate\Integration\Http;

use App\Tests\Modules\Utils\Authentication\CreateUser;
use App\Tests\Modules\Utils\Candidate\SkillService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class StoreSkillTest extends WebTestCase
{
    private const API_URL = '/api/candidate/skill';
    private const SKILL_NAME = 'CQRS';

    /** @test */
    public function shouldStoreCompany(): void
    {
        $client = self::createClient();

        $apiToken = CreateUser::createUser();

        $client->request(
            Request::METHOD_POST,
            self::API_URL,
            server: ['HTTP_X_AUTH_TOKEN' => $apiToken,],
            content: json_encode(
                [
                    'name' => self::SKILL_NAME,
                ]
            )
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertTrue(SkillService::existsByName(self::SKILL_NAME));
    }

    /** @test */
    public function shouldNotStoreSkillFromUnauthorizedApiUser(): void
    {
        $client = self::createClient();

        $client->request(
            Request::METHOD_POST,
            self::API_URL,
            content: '{"name": "CQRS"}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
