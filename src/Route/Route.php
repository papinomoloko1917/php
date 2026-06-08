<?php

declare(strict_types=1);

namespace App\Route;

use Closure;

class Route
{
    public function __construct(
        private string $path,
        private string $method,
        private array|Closure $handler,
    ) {
    }
    public static function get(string $path, Closure|array $handler): self
    {
        return new self(
            $path,
            'GET',
            $handler
        );
    }
    public static function post(string $path, Closure|array $handler): self
    {
        return new self(
            $path,
            'POST',
            $handler
        );
    }
    public function method(): string
    {
        return $this->method;
    }
    public function handler(): Closure|array
    {
        return $this->handler;
    }
}
