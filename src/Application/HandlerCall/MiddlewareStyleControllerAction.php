<?php

namespace Application\HandlerCall;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Application\HandlerCallInterface;


class MiddlewareStyleControllerAction implements HandlerCallInterface
{
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function call($handler, $vars, ServerRequestInterface $request, ResponseInterface $response, callable $next) : ResponseInterface
    {
        // Hello.foo
        list($controllerShortName, $action) = explode('.', $handler);

        $controller = $this->container->get($controllerShortName.'Controller');

        return call_user_func([$controller, $action], $request, $response, $next);
    }
}
