<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Entity;

use App\Modules\Client\Domain\ValueObject\PermissionId;

class Permission
{
    public function __construct(
        private readonly PermissionId $id,
        private readonly string $name
    ) {}
}
