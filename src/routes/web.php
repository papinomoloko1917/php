<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ShopController;
use App\Controllers\AboutController;
use App\Route\Route;

return [
  new Route('/', 'GET', [HomeController::class, 'index']),
  new Route('/shop', 'GET', [ShopController::class, 'index']),
  new Route('/about', 'GET', [AboutController::class, 'index']),
];
