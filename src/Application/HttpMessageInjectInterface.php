<?php

namespace Application;

interface HttpMessageInjectInterface
{
    public function setRequest($request);

    public function setResponse($response);
}
