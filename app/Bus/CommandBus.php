<?php

namespace App\Bus;

use App\CommandHandlers\CommandHandlerInterface;
use App\Commands\CommandInterface;
use InvalidArgumentException;

class CommandBus
{
    public function dispatch(CommandInterface $command)
    {
        $handlerClass = get_class($command) . 'Handler';
        $handlerClass = str_replace('Commands', 'CommandHandlers', $handlerClass);
        $handlerInstance = app($handlerClass);

        if ($handlerInstance instanceof CommandHandlerInterface) {
            $handler = app($handlerClass);
            return $handler->handler($command);
        }

        throw new InvalidArgumentException(get_class($command) .
            'Handler is not found or does not implement CommandHandlerInterface');

    }
}