<?php
use Zend\Diactoros\Response;

return [
    new Relay\Middleware\ExceptionHandler(new Response),
    new Relay\Middleware\ResponseSender,
    //new Application\Dispatcher(require 'dispatcher.php'),
    new Application\Middleware(require 'container.php'),
    new Application\NotFound,
];
