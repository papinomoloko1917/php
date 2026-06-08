<?php

declare(strict_types=1);

use App\Route\Route;

return [
Route::get('/', fn () => 'home'),
Route::get('/about', fn () => 'about'),
];
