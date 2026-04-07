<?php

namespace App\Route;

final class Route {
    public function __construct(
        private readonly string $path,
        private readonly string $method,
        private readonly array $handler,
    ) {
    }
    public function path() {
        return $this->path;
    }
    public function method() {
        return $this->method;
    }
    public function handler() {
        return $this->handler;
    }
}
