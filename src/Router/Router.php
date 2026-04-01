<?php

namespace App\Router;

class Router
{
  public function resolve(string $url, array $routes)
  {
    foreach ($routes as $route) {
      if ($url === $route['url']) {
        include __DIR__ . '/../../public/pages/' . $route['filePath'];
        exit;
      }
    }
    http_response_code(404);
    echo '404 Not Found';
  }
}
