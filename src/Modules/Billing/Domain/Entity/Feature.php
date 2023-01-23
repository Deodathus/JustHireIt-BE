<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Entity;

use App\Modules\Billing\Domain\ValueObject\FeatureId;

class Feature
{
    public function __construct(
        private readonly FeatureId $id,
        private readonly string $name
    ) {}

    public function getId(): FeatureId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
