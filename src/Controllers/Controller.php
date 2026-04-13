<?php

declare(strict_types=1);

namespace App\Controllers;

use RuntimeException;

abstract class Controller {
    protected function view(string $template, array $data = []): void {
        $viewPath = dirname(__DIR__, 2) . "/resources/views/{$template}.php";
        if (!file_exists($viewPath)) {
            throw new RuntimeException('Файла не существует');
        }
        extract($data, EXTR_SKIP);
        require $viewPath;
    }
}
