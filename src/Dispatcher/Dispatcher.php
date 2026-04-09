<?php

declare(strict_types=1);

namespace App\Dispatcher;

use RuntimeException;

final class Dispatcher implements DispatcherInterface {
  public function __construct() {
  }
  public function dispatch(array $handler): mixed {
    if (count($handler) !== 2) {
      throw new RuntimeException('Неверный формат обработчика');
    }
    [$targetController, $method] = $handler;
    if (!is_string($targetController) || !is_string($method)) {
      throw new RuntimeException('Обработчик должен содержать имя класса и метода');
    }
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
