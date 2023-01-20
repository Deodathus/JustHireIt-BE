<?php

declare(strict_types=1);

namespace App\Modules\Client\Application\DTO;

final class ClientApiTokenDTO
{
    public function __construct(public readonly string $apiToken) {}
}
