<?php

declare(strict_types=1);

use App\Controller\AboutController;
use App\Controller\HomeController;
use App\Route\Route;

return [
    new Route('/', 'GET', [HomeController::class, 'index']),

    new Route('/app', 'POST', [HomeController::class, 'index']), // Тестирую метод POST

    new Route('/about', 'GET', [AboutController::class, 'index']),
];
