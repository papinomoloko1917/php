<?php

declare(strict_types=1);

$bootstrap = require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

use App\Request\Request;
use App\Router\Router;
use App\App;
use App\Route\Route;

// Собираем приложение
$request = Request::fromGlobals();
$routes = require dirname(__DIR__) . '/src/routes/web.php';
$router = new Router($routes, $request);
$app = new App($router);

// Запускаем приложение
echo $app->run();
