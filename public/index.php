<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

error_reporting(APP_DEBUG ? E_ALL : 0);
ini_set('display_errors', APP_DEBUG ? '1' : '0');

use App\Request\Request;
use App\ErrorHandler\ExceptionHandler;
use App\Routing\Router\Router;
use App\Dispatcher\Dispatcher;
use App\App;

// Собираем приложение
$request = Request::fromGlobals();
$routes = require dirname(__DIR__) . '/routes/web.php';
$router = new Router($routes, $request);
$dispatcher = new Dispatcher();
$exceptionHandler = new ExceptionHandler(APP_DEBUG);

$app = new App($router, $dispatcher, $exceptionHandler); // Инициализируем приложение

$app->run(); // Запускаем приложение
