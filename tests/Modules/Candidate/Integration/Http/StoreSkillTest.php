<?php

declare(strict_types=1);

namespace App\Tests\Modules\Candidate\Integration\Http;

use App\Tests\Modules\Utils\CreateUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class StoreSkillTest extends WebTestCase
{
    private const API_URL = '/api/candidate/skill';

    /** @test */
    public function shouldStoreCompany(): void
    {
        $client = self::createClient();

        $apiToken = CreateUser::createUser();

        $client->request(
            Request::METHOD_POST,
            self::API_URL,
            server: ['HTTP_X_AUTH_TOKEN' => $apiToken,],
            content: '{"name": "CQRS"}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
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
