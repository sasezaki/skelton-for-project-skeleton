<?php
namespace Application;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Interop\Container\ContainerInterface as Container;

use FastRoute;

class Dispatcher
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, callable $next) {

            $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

            switch ($routeInfo[0]) {
                case FastRoute\Dispatcher::NOT_FOUND:
                    return $next($request, $response);
                    break;
                case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    $response = $response->withStatus(405);
                    break;
                case FastRoute\Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    call_user_func($handler, $request, $response, $vars);
                    break;
            }

            return $response;
    }
}
