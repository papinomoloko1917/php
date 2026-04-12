<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/bootstrap/bootstrap.php';

error_reporting(E_ALL);

// use App\Request\Request;
// use App\Router\Router;
// use App\App;
// use App\Dispatcher\Dispatcher;

// // Собираем приложение
// $request = Request::fromGlobals();
// $routes = require dirname(__DIR__) . '/routes/web.php';
// $router = new Router($routes, $request);
// $dispatcher = new Dispatcher();
// $app = new App($router, $dispatcher);

// // Запускаем приложение
// $app->run();

try {
    $routes = [
        ['path' => '/home', 'method' => 'GET'],
        ['path' => '/about', 'method' => 'GET'],
        ['path' => '/tools', 'method' => 'GET'],
    ];

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    $foundRoute = null;

    function resolve(array $routes, string $uri, string $method) {
        foreach ($routes as $route) {
            if ($route['path'] === $uri) {
                if (!isset($route['method'])) {
                    http_response_code(404);
                    throw new \RuntimeException('Некорректный формат маршрута, отсутствует метод');
                }
                if ($route['method'] !== $method) {
                    http_response_code(405);
                    throw new \RuntimeException('Метод не найден');
                }
                return $route;
            }
        }
        return null;
    }
    $foundRoute = resolve($routes, $uri, $method);
    if ($foundRoute === null) {
        http_response_code(404);
        throw new \RuntimeException('Маршрут не найден');
    }
    if (!isset($foundRoute['path'], $foundRoute['method'])) {
        http_response_code(405);
        throw new \RuntimeException('Некорректный формат маршрута');
    }
    echo "Маршрут найден - {$foundRoute['path']}";
} catch (\Throwable $e) {
    dump($e);
}
