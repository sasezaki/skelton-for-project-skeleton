<?php

namespace Application\HandlerCall;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Application\HandlerCallInterface;
use Application\HttpMessageInjectInterface;

class ParamsIsArgsControllerAction implements HandlerCallInterface
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

        if ($controller instanceof HttpMessageInjectInterface) {
            $controller->setRequest($request);
            $controller->setResponse($response);
        }

        return call_user_func_array([$controller, $action], $vars);
    }
}
