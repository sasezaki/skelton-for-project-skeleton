<?php

namespace Sample;

class HelloController
{
    public function __construct($twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function foo($request, $response, $next)
    {
        $html = $this->twigEnvironment->loadTemplate('hello.html')->render(['name' => 'John']);

        $response->getBody()->write($html);
        return $response;
    }
}
