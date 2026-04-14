<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;

class AboutController extends Controller {
    public function index(): Response {
        return $this->view('about', ['title' => 'About page']);
    }
}
