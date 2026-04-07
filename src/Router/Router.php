<?php

declare(strict_types=1);

namespace App\Router;

use App\Http\Request\Request;
use RuntimeException;
use App\Http\Response\Response;
use App\Route\Route;

class Router {
  /**
   * @param Route[] $routes
   */
  public function __construct(
    private array $routes,
  ) {
  }
  public function resolve(Request $request): Response {
    foreach ($this->routes as $route) {
      if ($route->path() === $request->path() && $route->method() === $request->method()) {
        return $this->dispatch($route->handler(), $request);
      }
    }
    return new Response('404 Not Found', 404);
  }

  private function dispatch(array $handler, Request $request): Response {

    if (count($handler) !== 2) {
      throw new RuntimeException('Некорректный обработчик маршрута');
    }

    [$controllerClass, $method] = $handler;

    if (!class_exists($controllerClass)) {
      throw new RuntimeException("Контроллер {$controllerClass} не найден");
    }
    $controller = new $controllerClass();

    if (!method_exists($controller, $method)) {
      throw new RuntimeException("Метод {$method} контроллера {$controllerClass} не найден");
    }

    $response = $controller->$method($request);

    if (!$response instanceof Response) {
      throw new RuntimeException('Контроллер должен возвращать объект Response');
    }
    return $response;
  }
}
