<?php

declare(strict_types=1);

namespace App\Http\Request;

class Request
{
  public function __construct(
    private string $uri,
    private string $method,
    private string $path,
  ) {}
  public static function fromGlobals(): self
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $method = $_SERVER['REQUEST_METHOD'];
    $path = rtrim(parse_url($uri, PHP_URL_PATH), '/');
    $path = $path ?: '/';

    return new self(
      uri: $uri,
      method: $method,
      path: $path,
    );
  }

  public function path()
  {
    return $this->path;
  }
  public function uri()
  {
    return $this->uri;
  }
  public function method()
  {
    return $this->method;
  }
}
