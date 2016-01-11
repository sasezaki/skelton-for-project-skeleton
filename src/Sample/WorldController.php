<?php

namespace Sample;

use Application\HttpMessageInjectTrait;
use Application\HttpMessageInjectInterface;

class WorldController implements HttpMessageInjectInterface
{
    use HttpMessageInjectTrait;

    public function __construct($twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    public function foo($name)
    {
        $html = $this->twigEnvironment->loadTemplate('hello.html')->render(['name' => $name]);

        $response = $this->response;

        $response->getBody()->write($html);
        return $response;
    }
}
