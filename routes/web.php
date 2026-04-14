<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Http\Response;
use App\Routing\Route;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/about', [AboutController::class, 'index']),
    Route::get('/test', function (): Response {
        return new Response('12345');
    }),
];
