<?php

declare(strict_types=1);

namespace App;

use App\Dispatcher\DispatcherInterface;
use App\Router\RouterInterface;

class App
{
  public function __construct(
    private RouterInterface $router,
    private DispatcherInterface $dispatcher,
  ) {}
  public function run(): mixed
  {
    $route = $this->router->resolve();

    return $this->dispatcher->dispatch($route->handler());
  }
}
