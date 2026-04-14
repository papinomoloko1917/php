<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\ErrorHandler\ExceptionHandler;
use App\Http\Response;
use App\Routing\RouterInterface;
use Throwable;

final class App {
    public function __construct(
        private readonly RouterInterface $router,
        private readonly DispatcherInterface $dispatcher,
        private readonly ExceptionHandler $exceptionHandler,
    ) {
    }
    public function run(): Response {
        try {
            $route = $this->router->resolve();
            return $this->dispatcher->dispatch($route->handler());
        } catch (Throwable $e) {
            return $this->exceptionHandler->handle($e);
        }
    }
}
