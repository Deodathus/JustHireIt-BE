<?php

declare(strict_types=1);

namespace App\SharedInfrastructure\Messenger;

use App\Shared\Application\Messenger\Event;
use App\Shared\Application\Messenger\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MessengerEventBus implements EventBus
{
    public function __construct(private readonly MessageBusInterface $eventBus) {}

    public function dispatch(Event $event): mixed
    {
        return $this->eventBus->dispatch($event)->last(HandledStamp::class)?->getResult();
    }
}
