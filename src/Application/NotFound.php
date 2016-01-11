<?php

namespace Application;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class NotFound
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next) 
    {
        $response->getBody()->write('NOT FOUND');
        return $response->withStatus(404);
    }
}
