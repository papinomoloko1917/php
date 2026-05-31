<?php

declare(strict_types=1);

namespace App\Dispatch;

use App\Request\Request;
use App\Routing\Route;
use App\View\View;
use RuntimeException;

final class Dispatcher
{
    public function __construct(
        private readonly View $view,
        private readonly Request $request,
    ) {
    }
    public function dispatch(Route $targetRoute): string
    {
        $handle = $targetRoute->handle();
        if (is_callable($handle)) {
            return $handle();
        } else {
            [$controller, $method] = $handle;
            if (empty($controller)) {
                throw new RuntimeException('Контроллер не найден', 500);
            }
            if (empty($method)) {
                throw new RuntimeException('Метод не найден', 500);
            }
            if (!class_exists($controller)) {
                throw new RuntimeException("Класс {$controller} не найден");
            }
            $targetController = new $controller(
                $this->view,
                $this->request,
            );
            if (!method_exists($targetController, $method)) {
                throw new RuntimeException("Метод {$method} контроллера {$controller} не найден");
            }
            return $targetController->$method();
        }
    }
}
