<?php

declare(strict_types=1);

namespace App\Tests\Modules\Utils\SharedInfrastructure\Messenger;

use App\Shared\Application\Messenger\Command;
use App\Shared\Application\Messenger\CommandBus;

final class CommandBusSpy implements CommandBus
{
    /**
     * @var Command[]
     */
    private array $dispatchedCommands = [];

    public function dispatch(Command $command): mixed
    {
        $this->dispatchedCommands[] = $command::class;

        return null;
    }

    public function wasCommandDispatched(string $command): bool
    {
        return in_array($command, $this->dispatchedCommands);
    }
}
