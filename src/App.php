<?php

declare(strict_types=1);

namespace App;

use App\Container\Container;

final class App
{
    private readonly Container $container;
    public function __construct()
    {
        $this->container = new Container();
    }
    public function run()
    {
        dump($this->container->router);
    }
}
