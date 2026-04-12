<?php

declare(strict_types=1);

namespace App\Routing\Router;

use App\Request\Request;
use App\Routing\Route\Route;
use App\Exceptions\RouteIncorrectException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;

class Router implements RouterInterface {
    public function __construct(
        private array $routes,
        private Request $request,
    ) {
    }
    public function resolve(): Route {
        $pathMatched = false;
        foreach ($this->routes as $route) {
            if (!$route instanceof Route) {
                throw new RouteIncorrectException('Некорректный маршрут');
            }
            if ($route->path() === $this->request->path()) {
                $pathMatched = true;
                if ($route->method() === $this->request->method()) {
                    return $route;
                }
            }
        }
        if ($pathMatched) {
            throw new MethodNotAllowedException('Метод не разрешен');
        }
        throw new RouteNotFoundException('Маршрут не найден');
    }
}
