<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\ErrorHandler\ExceptionHandler;
use App\Routing\Router\RouterInterface;
use Throwable;

class App {
    public function __construct(
        private readonly RouterInterface $router,
        private readonly DispatcherInterface $dispatcher,
        private readonly ExceptionHandler $exceptionHandler,
    ) {
    }
    public function run(): void {
        try {
            $route = $this->router->resolve();
            $this->dispatcher->dispatch($route->handler());
        } catch (Throwable $e) {
            $this->exceptionHandler->handle($e);
        }
    }
}
