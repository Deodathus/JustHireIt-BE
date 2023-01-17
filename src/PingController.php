<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\JsonResponse;

final class PingController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'OK',
            ]
        );
    }
}
