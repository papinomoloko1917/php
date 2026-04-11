<?php

declare(strict_types=1);

namespace App\Route;

use App\Exceptions\RouteIncorrectException;

final class Route {
    public function __construct(
        /** @param array {0: class-string, 1: string} $handler */
        private readonly string $path,
        private readonly string $method,
        private readonly array $handler,
    ) {
        if ($path === '') {
            throw new RouteIncorrectException('Путь маршрута не может быть пустым');
        }
        if (count($handler) !== 2 || !is_string($handler[0]) || !is_string($handler[1])) {
            throw new RouteIncorrectException('Некорректный обработчик маршрута');
        }
    }
    public function path(): string {
        return $this->path;
    }
    public function method(): string {
        return strtoupper($this->method);
    }
    /** @return array {0: class-string, 1: string} */
    public function handler(): array {
        return $this->handler;
    }
}
