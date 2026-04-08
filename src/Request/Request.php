<?php

declare(strict_types=1);

namespace App\Request;

class Request {
    public function __construct(
        private string $uri,
        private string $method,
        private string $path,
    ) {
    }
    public static function fromGlobals(): self {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $path = rtrim(parse_url($uri, PHP_URL_PATH), '/');
        $path = $path ?: '/';

        return new self(
            uri: $uri,
            method: $method,
            path: $path,
        );
    }
    public function uri(): string {
        return $this->uri;
    }
    public function method(): string {
        return $this->method;
    }
    public function path(): string {
        return $this->path;
    }
}
