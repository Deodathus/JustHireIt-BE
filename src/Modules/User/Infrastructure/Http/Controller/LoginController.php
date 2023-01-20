<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Http\Controller;

use App\Modules\User\Infrastructure\Http\Request\LoginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        return new JsonResponse();
    }
}
