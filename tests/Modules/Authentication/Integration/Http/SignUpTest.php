<?php

declare(strict_types=1);

namespace App\Tests\Modules\Authentication\Integration\Http;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class SignUpTest extends WebTestCase
{
    private const API_URL = '/api/auth/signup';

    /** @test */
    public function shouldStoreUser(): void
    {
        $client = self::createClient();

        $client->request(
            Request::METHOD_POST,
            self::API_URL,
            content: '{"login": "admin","email": "test@example.com","password": "password"}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
