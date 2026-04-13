<?php

declare(strict_types=1);

namespace App\Dispatcher;

use RuntimeException;
use Closure;

final class Dispatcher implements DispatcherInterface {
    public function __construct() {
    }
    /** @param array {0: class-string, 1: string} $handler */
    public function dispatch(array|Closure $handler): mixed {
        if ($handler instanceof Closure) {
            return $handler();
        }
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
