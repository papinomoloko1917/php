<?php

declare(strict_types=1);

namespace App\Router;

use App\Http\Request\Request;

class Router
{
  public function __construct(
    private array $routes,
  ) {}
  public function resolve(Request $request)
  {
    foreach ($this->routes as $route) {
      if ($route['url'] === $request->uri() && $route['method'] === $request->method()) return $route['handler']();
    }
    http_response_code(404);
    return '404 Not Found';
  }
}
