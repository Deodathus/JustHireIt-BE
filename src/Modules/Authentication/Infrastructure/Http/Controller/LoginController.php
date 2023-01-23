<?php

declare(strict_types=1);

namespace App\Modules\Authentication\Infrastructure\Http\Controller;

use App\Modules\Authentication\Infrastructure\Http\Request\LoginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        return new JsonResponse();
    }
}
