<?php

declare(strict_types=1);

namespace App\Routing\Route;

use App\Exceptions\RouteIncorrectException;
use Closure;

final class Route {
    private readonly string $path;
    private readonly string $method;
    private readonly array|Closure $handler;

    /** @param array {0: class-string, 1: string}|Closure $handler */
    public function __construct(string $path, string $method, array|Closure $handler) {
        $this->path = $path;
        $this->method = strtoupper($method);
        $this->handler = $handler;

        if ($path === '') {
            throw new RouteIncorrectException('Путь маршрута не может быть пустым');
        }
        $this->isValidHandler($this->handler());
    }
    /** @param array {0: class-string, 1: string} $handler */
    public static function get(string $path, array|Closure $handler): self {
        return new self($path, 'GET', $handler);
    }
    /** @param array {0: class-string, 1: string}|Closure $handler */
    public static function post(string $path, array|Closure $handler): self {
        return new self($path, 'POST', $handler);
    }
    public function path(): string {
        return $this->path;
    }
    public function method(): string {
        return $this->method;
    }
    /** @return array {0: class-string, 1: string}|Closure */
    public function handler(): array|Closure {
        return $this->handler;
    }
    //Поддержка функций в контроллере
    private function isValidHandler(array|Closure $handler): bool {
        if ($handler instanceof Closure) {
            return true;
        }
        return count($handler) === 2
            && is_string($handler[0])
            && is_string($handler[1]);
    }
}
