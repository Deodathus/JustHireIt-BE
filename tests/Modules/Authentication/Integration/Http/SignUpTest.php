<?php

declare(strict_types=1);

namespace App\Tests\Modules\Authentication\Integration\Http;

use App\Tests\Modules\Utils\Authentication\UserService;
use App\Tests\Modules\Utils\Job\CompanyService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/** @group integration */
final class SignUpTest extends WebTestCase
{
    private const API_URL = '/api/auth/signup';
    private const USER_LOGIN = 'admin';
    private const COMPANY_NAME = 'Test company';
    private const COMPANY_DESCRIPTION = 'Test company description';

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

    /** @test */
    public function shouldStoreUserAsRecruiter(): void
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
                    'companyName' => self::COMPANY_NAME,
                    'companyDescription' => self::COMPANY_DESCRIPTION,
                ]
            )
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertTrue(UserService::existsByLogin(self::USER_LOGIN));
        $this->assertTrue(CompanyService::existsByName(self::COMPANY_NAME));
    }
}
