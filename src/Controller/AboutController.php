<?php

declare(strict_types=1);

namespace App\Controller;

class AboutController extends Controller
{
    public function index(): string
    {
        return $this->view('about', ['tittle' => 'О нас']);
    }
}
