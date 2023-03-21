<?php

declare(strict_types=1);

namespace App\Tests\Modules\Authentication\Integration\Http;

use App\Modules\Billing\Domain\Entity\Plan;
use App\Modules\Billing\Domain\Enum\Features;
use App\Tests\Modules\Utils\Authentication\CreateUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class GetMeTest extends WebTestCase
{
    private const API_URL = '/api/auth/me';
    private const TEST_LOGIN = 'test';
    private const TEST_EMAIL = 'test@example.com';
    private const TEST_PASSWORD = 'password';
    private const TEST_TEAM = 'Users';

    /** @test */
    public function shouldReturnUserData(): void
    {
        $client = self::createClient();

        $apiToken = CreateUser::createUser(
            self::TEST_LOGIN,
            self::TEST_PASSWORD,
            self::TEST_EMAIL
        );

        $client->request(
            Request::METHOD_GET,
            self::API_URL,
            server: ['HTTP_X_AUTH_TOKEN' => $apiToken,],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $response = json_decode($client->getResponse()->getContent());

        $this->assertSame(self::TEST_LOGIN, $response->me->login);
        $this->assertSame(self::TEST_EMAIL, $response->me->email);
        $this->assertSame(self::TEST_TEAM, $response->me->team);
        $this->assertSame(
            array_map(fn (Features $feature): string => $feature->value, Plan::CANDIDATE_START_PLAN_FEATURES),
            $response->me->features
        );
    }

    /** @test */
    public function shouldNotGetFromUnauthorizedApiUser(): void
    {
        $client = self::createClient();

        $client->request(
            Request::METHOD_GET,
            self::API_URL
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
