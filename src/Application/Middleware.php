<?php
namespace Application;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Container\ContainerInterface;

use FastRoute\Dispatcher;

use Application\HandlerCallInterface;

class Middleware
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $dispatcher = $this->container->get(Dispatcher::class);
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return $next($request, $response);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response = $response->withStatus(405);
                break;
            case Dispatcher::FOUND:
                
                if (!$this->container->has(HandlerCallInterface::class)) {
                    throw new \RuntimeException('HandlerCallInterface Service not registerd');
                }

                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $handlerCaller = $this->container->get(HandlerCallInterface::class);
                $response = $handlerCaller->call($handler, $vars, $request, $response, $next);
                break;
            }

        return $response;
    }
}
