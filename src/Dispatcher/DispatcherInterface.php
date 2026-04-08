<?php

declare(strict_types=1);

namespace App\Dispatcher;

interface DispatcherInterface
{
  public function dispatch(array $handler): mixed;
}
