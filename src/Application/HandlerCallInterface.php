<?php

namespace Application;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface HandlerCallInterface
{
    public function call($handler, $vars, ServerRequestInterface $request, ResponseInterface $response, callable $next) : ResponseInterface;

}
