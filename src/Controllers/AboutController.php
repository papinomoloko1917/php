<?php

declare(strict_types=1);

namespace App\Controllers;

class AboutController {
    public function index(): void {
        require dirname(__DIR__, 2) . '/resources/views/about.php';
    }
}
