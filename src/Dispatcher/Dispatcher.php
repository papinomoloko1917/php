<?php

declare(strict_types=1);

namespace App\Dispatcher;

use App\Factory\ControllerFactory;
use App\Route\Route;
use Closure;

class Dispatcher
{
    public function __construct(
        private readonly ControllerFactory $controllerFactory,
    ) {
    }
    public function dispatch(Route $existRoute): string
    {
        if ($existRoute->handler() instanceof Closure) {
            return $existRoute->handler()();
        }

        [$controllerClass, $method] = $existRoute->handler();

        $controller = $this->controllerFactory->make($controllerClass);

        return $controller->$method();
    }
}
