<?php

namespace App\Bus;

use App\Queries\QueryInterface;
use App\QueryHandlers\QueryHandlerInterface;
use InvalidArgumentException;

class QueryBus
{
    public function dispatch(QueryInterface $query)
    {
        $handlerClass = get_class($query) . 'Handler';
        $handlerClass = str_replace('Queries', 'QueryHandlers', $handlerClass);
        $handlerInstance = app($handlerClass);

        if ($handlerInstance instanceof QueryHandlerInterface) {
            $handler = app($handlerClass);
            return $handler->handler($query);
        }

        throw new InvalidArgumentException(get_class($query) .
            'Handler is not found or does not implement QueryHandlerInterface');

    }
}