<?php

declare(strict_types=1);

namespace App\Modules\User\Application\DTO;

final class UserApiTokenDTO
{
    public function __construct(public readonly string $apiToken) {}
}
