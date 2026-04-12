<?php

declare(strict_types=1);

namespace App\Routing\Router;

use App\Routing\Route\Route;

interface RouterInterface {
    public function resolve(): Route;
}
