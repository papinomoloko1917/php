<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\Request;
use RuntimeException;

class Router implements RouterInterface {
    public function __construct(
        private Request $request,
        private array $routes,
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
        http_response_code(404);
        throw new RuntimeException("Путь {$this->request->path()} или метод {$this->request->method()} не найдены");
    }
    private function dispatch($handler): mixed {
        if (count($handler) == 2) {
            [$controllerClass, $method] = $handler;
        } else {
            throw new RuntimeException("Некорректный обработик {$handler}");
        }
        if (!class_exists($controllerClass)) {
            throw new RuntimeException("Класс {$controllerClass} не найден");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Метод {$method} не найден в классе {$controllerClass}");
        }
        return $controller->$method();
    }
}
