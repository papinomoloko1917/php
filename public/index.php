<?php

declare(strict_types=1);

use App\App;
use App\Request\Request;
use App\Router\Router;

$rootPath = dirname(__DIR__);

require_once $rootPath . '/bootstrap/bootstrap.php';

$routes = require_once $rootPath . '/src/routes/web.php';

$request = Request::fromGlobals();

$router = new Router($request, $routes);

$app = new App($router);

$app->run();
