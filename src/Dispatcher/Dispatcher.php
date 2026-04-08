<?php

declare(strict_types=1);

namespace App\Dispatcher;

use RuntimeException;

final class Dispatcher implements DispatcherInterface
{
  public function __construct() {}
  public function dispatch(array $handler): mixed
  {
    if (empty($handler)) {
      throw new RuntimeException('Обработчик не найден');
    }
    [$targetController, $method] = $handler;
    if (!class_exists($targetController)) {
      throw new RuntimeException("Класс {$targetController} не найден");
    }
    $controller = new $targetController();
    if (!method_exists($controller, $method)) {
      throw new RuntimeException("Метод {$method} не найден");
    }
    return $controller->$method();
  }
}
