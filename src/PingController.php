<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class PingController
{
    public function __construct() {}

    public function __invoke(Request $request, Security $security): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'OK',
            ]
        );
    }
}
