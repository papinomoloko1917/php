<?php

declare(strict_types=1);

namespace App\Routing;

use Closure;

class Route
{
    public function __construct(
        private readonly string $path,
        private readonly string $method,
        private readonly array|Closure $handle,
    ) {
    }
    public static function get(string $path, array|Closure $handle): self
    {
        return new self(
            $path,
            $method = 'GET',
            $handle,
        );
    }
    public static function post(string $path, array|Closure $handle): self
    {
        return new self(
            $path,
            $method = 'POST',
            $handle,
        );
    }
    public function path(): string
    {
        return $this->path();
    }
    public function method(): string
    {
        return $this->method();
    }
    public function handle(): array|Closure
    {
        return $this->handle();
    }
}
