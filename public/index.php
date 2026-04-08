<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

use App\Request\Request;
use App\Router\Router;
use App\App;
use App\Dispatcher\Dispatcher;

// Собираем приложение
$request = Request::fromGlobals();
$routes = require dirname(__DIR__) . '/src/routes/web.php';
$router = new Router($routes, $request);
$dispatcher = new Dispatcher();
$app = new App($router, $dispatcher);

// Запускаем приложение
$app->run();
