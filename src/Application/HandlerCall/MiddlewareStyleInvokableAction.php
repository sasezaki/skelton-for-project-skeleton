<?php

namespace Application\HandlerCall;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Application\HandlerCallInterface;


class MiddlewareStyleInvokableAction implements HandlerCallInterface
{
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function call($handler, $vars, ServerRequestInterface $request, ResponseInterface $response, callable $next) : ResponseInterface
    {
        $action = $this->container->get($handler);
        return call_user_func($action, $request, $response, $next);
    }
}
