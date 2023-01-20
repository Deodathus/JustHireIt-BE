<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Service;

use App\Modules\Client\Domain\Entity\Client;

interface ClientPersisterInterface
{
    public function persist(Client $client): void;
}
