<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController extends Controller
{
    public function index(): string
    {
        return $this->view('home', ['tittle' => 'Домашняя страница']);
    }
}
