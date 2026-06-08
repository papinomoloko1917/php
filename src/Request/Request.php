<?php

declare(strict_types=1);

namespace App\Request;

use InvalidArgumentException;
use Uri\Rfc3986\Uri;

class Request
{
    public function __construct(
        public readonly array $server,
        public readonly string $uri,
        public readonly string $rawPath,
        public readonly string $path,
        public readonly string $queryString,
        public readonly string $method,
        public readonly array $post,
        public readonly array $get,
    ) {
    }
    public static function createFromGlobals(): self
    {
        $server = $_SERVER ?? [];
        $requestUri = (string) ($server['REQUEST_URI'] ?? '/');

        $parsedUri = Uri::parse($requestUri);

        if ($parsedUri === null) {
            throw new InvalidArgumentException('Malformed request URI.');
        }

        $rawPath = $parsedUri->getRawPath();
        $path = self::normalizeRoutePath($parsedUri->getPath());

        $post = $_POST ?? [];
        $get = $_GET ?? [];

        return new self(
            server: $server,
            uri: $requestUri,
            rawPath: $rawPath,
            path: $path,
            queryString: $parsedUri->getRawQuery() ?? '',
            method: (string) ($server['REQUEST_METHOD'] ?? 'GET'),
            post: $post,
            get: $get,
        );
    }
    private static function normalizeRoutePath(string $path): string
    {
        if ($path === '' || $path === '/') {
            return '/';
        }

        return rtrim($path, '/') ?: '/';
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
    public function method(): string
    {
        return $this->method;
    }
    public function path(): string
    {
        return $this->path;
    }
    public function input(string $name): ?string
    {
        if (isset($this->post[$name])) {
            return $this->post[$name];
        }
        return null;
    }
}
