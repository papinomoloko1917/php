<?php

declare(strict_types=1);

namespace App;

use App\Router\Router;

class App {
    public function __construct(
        private Router $router,
    ) {
    }
    public function run(): void {
        $this->router->resolve();
    }
}
