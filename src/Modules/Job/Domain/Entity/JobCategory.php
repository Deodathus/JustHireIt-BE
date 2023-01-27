<?php

declare(strict_types=1);

namespace App\Modules\Job\Domain\Entity;

use App\Modules\Job\Domain\ValueObject\JobCategoryId;

class JobCategory
{
    public function __construct(
        private readonly JobCategoryId $id,
        private readonly string $name
    ) {}

    public function getId(): JobCategoryId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
