<?php

declare(strict_types=1);

namespace App;

use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class PingController
{
    public function __construct(private readonly UserRepository $repository) {}

    public function __invoke(Request $request, Security $security): JsonResponse
    {
//        $this->repository->store(User::generate());

        return new JsonResponse(
            [
                'status' => 'OK',
            ]
        );
    }
}
