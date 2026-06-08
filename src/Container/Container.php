<?php

declare(strict_types=1);

namespace App\Container;

use App\Database\Database;
use App\Product\Product;
use App\Request\Request;
use App\Router\Router;
use App\View\View;

class Container
{
    public readonly array $routes;
    public readonly Request $request;
    public readonly Router $router;
    public readonly View $view;
    public readonly Database $database;
    public readonly Product $product;

    public function __construct()
    {
        $this->registerServices();
    }
    private function registerServices()
    {
        $this->routes = require APP_PATH . '/routes/routes.php';

        $this->request = Request::createFromGlobals();

        $this->router = new Router(
            $this->routes,
            $this->request->path(),
            $this->request->method(),
        );

        $this->view = new View();

        $this->database = Database::fromEnv();

        $this->product = new Product($this->database);
    }
}
