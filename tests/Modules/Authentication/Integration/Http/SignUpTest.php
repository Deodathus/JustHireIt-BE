<?php

declare(strict_types=1);

namespace App\Tests\Modules\Authentication\Integration\Http;

use App\Tests\Modules\Utils\Authentication\UserService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class SignUpTest extends WebTestCase
{
    private const API_URL = '/api/auth/signup';
    private const USER_LOGIN = 'admin';

    /** @test */
    public function shouldStoreUser(): void
    {
        $client = self::createClient();

        $client->request(
            Request::METHOD_POST,
            self::API_URL,
            content: json_encode(
                [
                    'login' => self::USER_LOGIN,
                    'email' => 'test@example.com',
                    'password' => 'password',
                ]
            )
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertTrue(UserService::existsByLogin(self::USER_LOGIN));
    }
}
