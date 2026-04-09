<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\Router\RouterInterface;
use Throwable;

class App {
  public function __construct(
    private RouterInterface $router,
    private DispatcherInterface $dispatcher,
  ) {
  }
  public function run(): void {
    try {
      $route = $this->router->resolve();
      $this->dispatcher->dispatch($route->handler());
    } catch (Throwable $e) {
      http_response_code(500);
      echo $e->getMessage();
    }
  }
}
