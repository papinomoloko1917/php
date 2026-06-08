<?php

declare(strict_types=1);

namespace App\Factory;

use App\Controller\ProductController;
use App\Database\Database;
use App\Request\Request;
use App\View\View;

class ControllerFactory
{
    public function __construct(
        private readonly View $view,
        private readonly Request $request,
        private readonly Database $database,
    ) {
    }
    public function make(string $controllerClass)
    {
        if ($controllerClass === ProductController::class) {
            return new $controllerClass(
                $this->view,
                $this->request,
                $this->database,
            );
        }
        return new $controllerClass(
            $this->view,
            $this->request,
        );
    }
}
