<?php
use Relay\RelayBuilder;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(__DIR__ . '/../');

require_once 'vendor/autoload.php';

(new Relay\RelayBuilder)
    ->newInstance(require 'config/middlewares.php')
    (ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES), new Response);
