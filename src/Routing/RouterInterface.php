<?php

declare(strict_types=1);

namespace App\Routing;

use App\Routing\Route;

interface RouterInterface {
    public function resolve(): Route;
}
