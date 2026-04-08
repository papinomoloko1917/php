<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\Request;
use RuntimeException;

class Router implements RouterInterface {
    public function __construct(
        private array $routes,
        private Request $request,
    ) {
    }
    public function resolve(): mixed {
        foreach ($this->routes as $route) {
            if (
                $route->path() === $this->request->path() &&
                $route->method() === $this->request->method()
            ) {
                return $this->dispatch($route->handler());
            }
        }
        throw new RuntimeException("Не удалось найти маршрут");
    }
    private function dispatch($handler): mixed {
        if (empty($handler)) {
            throw new RuntimeException('Обработчик не найден');
        }
        [$targetController, $method] = $handler;
        if (!class_exists($targetController)) {
            throw new RuntimeException("Класс {$targetController} не найден");
        }
        $controller = new $targetController();
        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Метод {$method} не найден");
        }
        return $controller->$method();
    }
}
