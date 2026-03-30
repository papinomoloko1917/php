<?php

namespace App;

use App\Router\Router;

class App
{
    private string $url;
    private string $pageDir;
    private Router $router;

    public function __construct()
    {
        $this->url = $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->pageDir = $pageDir = __DIR__ . '/pages';
        $this->router = new Router();
    }

    public function run()
    {
        $this->router->resolve($this->url, $this->pageDir);
    }
}
