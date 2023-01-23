<?php

namespace App;

use App\Shared\Application\Messenger\CommandHandler;
use App\Shared\Application\Messenger\EventHandler;
use App\Shared\Application\Messenger\QueryHandler;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    private const MESSAGE_HANDLER_TAG = 'messenger.message_handler';

    use MicroKernelTrait;

    protected function build(ContainerBuilder $container)
    {
        $container
            ->registerForAutoconfiguration(CommandHandler::class)
            ->addTag(self::MESSAGE_HANDLER_TAG, ['bus' => 'command.bus']);

        $container
            ->registerForAutoconfiguration(QueryHandler::class)
            ->addTag(self::MESSAGE_HANDLER_TAG, ['bus' => 'query.bus']);

        $container
            ->registerForAutoconfiguration(EventHandler::class)
            ->addTag(self::MESSAGE_HANDLER_TAG, ['bus' => 'event.bus']);
    }
}
