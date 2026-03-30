<?php

namespace App\Router;

class Router
{
    private array $routes = [];
    private string $basePath;

    public function __construct(array $routes, string $basePath)
    {
        $this->routes = $routes;
        $this->basePath = $basePath;
    }

    public function resolve(string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($route['route'] === $uri) {
                $this->render($route['file_path']);
                return;
            }
        }

        http_response_code(404);
        echo 'Страница не найдена';
    }

    public function render(string $filePath)
    {
        $page = $this->basePath . $filePath;
        require_once $this->basePath . '/layout/app.layout.php';
    }
}
