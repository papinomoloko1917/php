<?php

use App\Router\Router;

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$uri = $uri === '' ? '/' : $uri;

$routes = require_once $dirname . '/routes/routes.php';

$router = new Router($routes, $dirname);
$router->resolve($uri);
