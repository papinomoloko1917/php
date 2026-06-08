<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\Request;
use App\Route\Route;

final class Router
{
    public function __construct(
        private readonly array $routes,
        private readonly string $path,
        private readonly string $method,
    ) {

    }
    public function handle()
    {
        foreach ($this->routes as $route) {
if($route['path'] === $this->path)
        }
    }
}
