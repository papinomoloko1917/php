<?php

declare(strict_types=1);

use App\Controller\AboutController;
use App\Controller\HomeController;
use App\Controller\ProductController;
use App\Routing\Route;

return [
Route::get('/', [HomeController::class, 'index']),
Route::get('/about', [AboutController::class, 'index']),
Route::get('/admin/products/add', [ProductController::class, 'add']),
Route::post('/admin/products/add', [ProductController::class, 'store']),
];
