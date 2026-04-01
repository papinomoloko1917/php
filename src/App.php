<?php

namespace App;

use App\Router\Router;

class App
{
  private string $url;

  private array $routes = [];

  public function __construct(private Router $router)
  {
    $url = rtrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/');
    $this->url = $url === '' ? '/' : $url;
    $this->routes = require __DIR__ . '/routes/routes.php';
  }

  public function run(): void
  {
    $this->router->resolve($this->url, $this->routes);
  }
}
