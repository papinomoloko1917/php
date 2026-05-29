<?php

declare(strict_types=1);

namespace App\Routing;

final class Router
{
    public function __construct(
        private readonly string $method,
        private readonly string $path,
        private readonly array $routes,
    ) {

    }
    public function resolve()
    {
        foreach ($this->routes as $route) {

        }
    }
}
