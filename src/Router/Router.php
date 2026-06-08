<?php

declare(strict_types=1);

namespace App\Router;

use App\Route\Route;
use RuntimeException;

final class Router
{
    public function __construct(
        private readonly array $routes,
        private readonly string $path,
        private readonly string $method,
    ) {

    }
    public function handle(): Route
    {
        $pathExists = false;
        foreach ($this->routes as $route) {
            if ($route->path() === $this->path) {
                $pathExists = true;
                if ($route->method() === $this->method) {
                    return $route;
                }
            }
        }
        if ($pathExists === true) {
            throw new RuntimeException('405 | Метод не действителен', 405);
        } else {
            throw new RuntimeException('404 | Страница не найдена', 404);
        }
    }
}
