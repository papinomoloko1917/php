<?php

declare(strict_types=1);

namespace App\Route;

final class Route {
    public function __construct(
        private readonly string $path,
        private readonly string $method,
        private readonly array $handler,
    ) {
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
