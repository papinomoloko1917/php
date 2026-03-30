<?php

namespace App\Router;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = include_once dirname(__DIR__) . '/routes/routes.php';
    }

    public function resolve($url, $pageDir) {}
}
