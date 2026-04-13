<?php

declare(strict_types=1);

namespace App\Dispatcher;

use Closure;

interface DispatcherInterface {
    public function dispatch(array|Closure $handler): mixed;
}
