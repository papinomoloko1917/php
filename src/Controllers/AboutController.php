<?php

namespace App\Controllers;

use App\Http\Request\Request;
use App\Http\Response\Response;

class AboutController {
    public function index(Request $request): Response {
        return new Response('О нас');
    }
}
