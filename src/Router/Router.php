<?php

declare(strict_types=1);

namespace App\Router;

use App\Request\Request;
use App\Route\Route;
use RuntimeException;

class Router implements RouterInterface
{
  public function __construct(
    private array $routes,
    private Request $request,
  ) {}
  public function resolve(): Route
  {
    foreach ($this->routes as $route) {
      if (
        $route->path() === $this->request->path() &&
        $route->method() === $this->request->method()
      ) {
        return $route;
      }
    }
    throw new RuntimeException("Не удалось найти маршрут");
  }
}
