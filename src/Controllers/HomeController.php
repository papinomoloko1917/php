<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request\Request;
use App\Http\Response\Response;

class HomeController {
    public function index(Request $request): Response {
        return new Response('Домашняя страница');
    }
}
