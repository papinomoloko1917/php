<?php

declare(strict_types=1);

namespace App\Route;

use InvalidArgumentException;

final class Route {
    private readonly string $path;
    private readonly string $method;
    private readonly array $handler;
    public function __construct(string $path, string $method, array $handler) {
        if (count($handler) !== 2) {
            throw new InvalidArgumentException('Handler должен быть в формате [Controller::class, method]');
        }
        $this->path = $path;
        $this->method = strtoupper($method);
        $this->handler = $handler;
    }
    public function path(): string {
        return $this->path;
    }

    public function method(): string {
        return $this->method;
    }

    public function handler(): array {
        return $this->handler;
    }
}
