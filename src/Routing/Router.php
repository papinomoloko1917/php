<?php

declare(strict_types=1);

namespace App\Routing;

use RuntimeException;

final class Router
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $routes,
    ) {

    }
    public function resolve(): Route
    {
        $pathFound = false;
        foreach ($this->routes as $route) {
            if ($route->path() === $this->path) {
                $pathFound = true;
                if ($route->method() === $this->method) {
                    return $route;
                }
            }
        }
        if ($pathFound) {
            throw new RuntimeException('Метод не найден | 405', 405);
        } else {
            throw new RuntimeException('404 | Страница не найдена', 404);
        }
    }
}
