<?php

declare(strict_types=1);

namespace App\Router;

interface RouterInterface {
    public function resolve(): mixed;
}
