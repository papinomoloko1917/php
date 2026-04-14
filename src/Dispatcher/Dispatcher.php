<?php

declare(strict_types=1);

namespace App\Dispatcher;

use App\Http\Response;
use RuntimeException;
use Closure;

final class Dispatcher implements DispatcherInterface {
    public function __construct() {
    }
    public function dispatch(array|Closure $handler): Response {
        $result = $handler instanceof Closure ? $handler() : $this->dispatchController($handler);
        if (!$result instanceof Response) {
            throw new RuntimeException('Обработчик маршрута должен возвращать экземпляр Response');
        }
        return $result;
    }
    private function dispatchController(array $handler): mixed {
        [$controllerClass, $method] = $handler;

        if (!class_exists($controllerClass)) {
            throw new RuntimeException("Класс {$controllerClass} не найден");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Метод {$method} не найден");
        }

        return $controller->{$method}();
    }
}
