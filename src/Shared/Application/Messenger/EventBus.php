<?php

declare(strict_types=1);

namespace App\Shared\Application\Messenger;

interface EventBus
{
    public function dispatch(Event $event): mixed;
}
