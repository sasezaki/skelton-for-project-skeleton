<?php

namespace Application;

trait HttpMessageInjectTrait //implements HttpMessageInjectInterface
{
    protected $request;
    protected $response;

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }
}
