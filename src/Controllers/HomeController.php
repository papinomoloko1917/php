<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;

class HomeController extends Controller {
    public function index(): Response {
        return $this->view('home', ['title' => 'Home page']);
    }
}
