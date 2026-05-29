<?php

declare(strict_types=1);

use App\Controller\HomeController;
use App\Routing\Route;

return [
Route::get('/', [HomeController::class, 'index']),
Route::get('/test', fn () => 'test'),
];
