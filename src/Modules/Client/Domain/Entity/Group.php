<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Entity;

use App\Modules\Client\Domain\Enum\Permissions;
use App\Modules\Client\Domain\ValueObject\ClientId;
use App\Modules\Client\Domain\ValueObject\GroupId;

class Group
{
    public const DEFAULT_PERMISSIONS = [
        Permissions::JOB_CREATE,
        Permissions::JOB_EDIT,
        Permissions::JOB_CLOSE,
        Permissions::JOB_DELETE,
        Permissions::JOB_POST_CREATE,
        Permissions::JOB_POST_EDIT,
        Permissions::JOB_POST_CLOSE,
        Permissions::JOB_POST_DELETE,
    ];

    /**
     * @param Permissions[] $permissions
     */
    public function __construct(
        private readonly GroupId $id,
        private readonly string $name,
        private readonly ClientId $owner,
        private readonly array $permissions
    ) {}

    public function getId(): GroupId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): ClientId
    {
        return $this->owner;
    }

    /**
     * @return Permissions[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
