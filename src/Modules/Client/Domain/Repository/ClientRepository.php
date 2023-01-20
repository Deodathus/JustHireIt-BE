<?php

declare(strict_types=1);

namespace App\Modules\Client\Domain\Repository;

use App\Modules\Client\Domain\Entity\Client;

interface ClientRepository
{
    public function fetchByToken(string $apiToken): Client;

    public function store(Client $client): void;
}
