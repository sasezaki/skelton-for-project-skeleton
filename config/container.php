<?php
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config;
use FastRoute\Dispatcher;

use Application\HandlerCallInterface;

return new ServiceManager(new Config([
    'factories' => [
 

        /**
         1. 
         If you want directory bind to route & Middleware Style Action callback,
            
            eg.
            $r->addRoute('GET', '/', function($request, $response, $next) {});

         Register `MiddlewareStyleDirectCallback`

            HandlerCallInterface::class => function () {
                return new Application\HandlerCall\MiddlewareStyleDirectCallback;
            },
         
         */

        /**
         2.
         If you want bind to route & Container's Action (Middleware Style)

            eg.
            $r->addRoute('GET', '/', 'HelloAction');

         Register `MiddlewareStyleInvokableAction`

         HandlerCallInterface::class => function ($container) {
            return new Application\HandlerCall\MiddlewareStyleInvokableAction($container);
         },
         */
        /**
        'HelloAction' => function ($container) {
            $twigEnvironment = $container->get('Twig_Environment');

            return function($request, $response, $next) use ($twigEnvironment) {
                $response->getBody()->write('Hello');
                return $response;
            };
        },*/


        /**
         3.
         If you want bind to route & Container's Controller,
          and call naming rule action (Middleware Style)

            eg.
            $r->addRoute('GET', '/', 'Hello.foo');

         Register `MiddlewareStyleControllerAction`

         HandlerCallInterface::class => function ($container) {
            return new Application\HandlerCall\MiddlewareStyleControllerAction($container);
         },
         */


        /**
         4.
         If you want bind to route & Container's Controller,
          and call naming rule action (router's vars(params) is passed as action's args)

            eg.
            $r->addRoute('GET', '/{name}', 'World.foo');

            public function foo($name)

         Register `ParamsIsArgsControllerAction`

         HandlerCallInterface::class => function ($container) {
            return new Application\HandlerCall\ParamsIsArgsControllerAction($container);
         },
         */


         HandlerCallInterface::class => function ($container) {
            return new Application\HandlerCall\ParamsIsArgsControllerAction($container);
         },



        'HelloController' => function ($container) {
            $twigEnvironment = $container->get('Twig_Environment');
            return new \Sample\HelloController($twigEnvironment);
        },
        'WorldController' => function ($container) {
            $twigEnvironment = $container->get('Twig_Environment');
            return new \Sample\WorldController($twigEnvironment);
        },
        Dispatcher::class => function ($container) {
            return FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
                
                //$r->addRoute('GET', '/', 'Hello.foo');

                $r->addRoute('GET', '/hello/{name}', 'World.foo');
            });
        },
        'Twig_Loader' => function($container) {
            return new Twig_Loader_Array($container->get('templates'));
        },
        'Twig_Environment' => function($container) {
            return new Twig_Environment($container->get('Twig_Loader'));
        },
    ],
    'services' => [
        'templates' => [
            'hello.html' => "Hello {{ name }}!\n"
        ]
    ]        
]));
