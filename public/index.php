<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

use App\App;
use App\Http\Request\Request;
use App\Router\Router;

$routes = require dirname(__DIR__) . '/src/routes/web.php';

$request = Request::fromGlobals();

$router = new Router($routes);

$app = new App($router, $request);
$app->run();
