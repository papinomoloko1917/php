<?php

declare(strict_types=1);

namespace App\Request;

class Request
{
    public function __construct(
        private readonly string $uri,
        private readonly string $method,
        private readonly string $path,
        private readonly array $server,
        private readonly array $post,
        private readonly array $get,
    ) {
    }
    public static function fromGlobals(): self
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($uri, PHP_URL_PATH);
        $path = $path ? rtrim($path, '/') : '/';
        $path = $path ?: '/';
        $server = $_SERVER ?? [];
        $post = $_POST ?? [];
        $get = $_GET ?? [];

        return new self(
            uri: $uri,
            method: $method,
            path: $path,
            server: $server,
            post: $post,
            get: $get,
        );
    }
    public function uri(): string
    {
        return $this->uri;
    }
    public function method(): string
    {
        return $this->method;
    }
    public function path(): string
    {
        return $this->path;
    }
    public function server(): array
    {
        return $this->server;
    }
    public function post(): array
    {
        return $this->post;
    }
    public function get(): array
    {
        return $this->get;
    }
    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }
}
