<?php

declare(strict_types=1);

namespace App\Controller;

use App\View\View;

abstract class Controller
{
    public function __construct(
        protected readonly View $view
    ) {
    }
    public function view(string $name, array $data = [])
    {
        return $this->view->page($name, $data);
    }
}
