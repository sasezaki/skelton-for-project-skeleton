<?php

namespace Application\HandlerCall;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Application\HandlerCallInterface;

class MiddlewareStyleDirectCallback implements HandlerCallInterface
{
    public function call($handler, $vars, ServerRequestInterface $request, ResponseInterface $response, callable $next) : ResponseInterface
    {
        return call_user_func($handler, $request, $response, $next);
    }
}
