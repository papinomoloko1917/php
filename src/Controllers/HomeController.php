<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController {
    public function index(): void {
        require dirname(__DIR__, 2) . '/resources/views/home.php';
    }
}
