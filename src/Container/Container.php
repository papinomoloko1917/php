<?php

declare(strict_types=1);

namespace App\Container;

use App\Dispatch\Dispatcher;
use App\Request\Request;
use App\Routing\Router;
use App\View\View;

class Container
{
    public readonly Request $request;
    public readonly Router $router;
    public readonly Dispatcher $dispatcher;
    public readonly View $view;
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

        $this->view = new View();

        $this->dispatcher = new Dispatcher(
            $this->view,
            $this->request,
        );
    }
}
