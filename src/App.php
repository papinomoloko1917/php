<?php

declare(strict_types=1);

namespace App;

use App\Http\Request\Request;
use App\Router\Router;

class App
{
  public function __construct(
    private Router $router,
    private Request $request,
  ) {}
  public function run()
  {
    $this->router->resolve($this->request);
  }
}
