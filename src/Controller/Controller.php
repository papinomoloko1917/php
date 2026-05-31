<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\Request;
use App\View\View;

abstract class Controller
{
    public function __construct(
        protected readonly View $view,
        protected readonly Request $request,
    ) {
    }
    public function view(string $name, array $data = []): string
    {
        return $this->view->page($name, $data);
    }
}
