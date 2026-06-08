<?php

declare(strict_types=1);

namespace App\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return $this->view('about');
    }
}
