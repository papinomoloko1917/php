<?php

declare(strict_types=1);

namespace App\Container;

use App\Request\Request;
use App\Routing\Router;

class Container
{
    public readonly Request $request;
    public readonly Router $router;
    public function __construct()
    {
        $this->registerService();
    }
    public function registerService(): void
    {
        $routes = require APP_PATH . '/routes/web.php';

        $this->request = Request::fromGlobals();

        $this->router = new Router(
            $this->request->method(),
            $this->request->path(),
            $routes,
        );
    }
}
