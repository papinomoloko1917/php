<?php

namespace App\Controllers;

use App\Http\Request\Request;
use App\Http\Response\Response;

class ShopController {
    public function index(Request $request): Response {
        return new Response('Магазин');
    }
}
