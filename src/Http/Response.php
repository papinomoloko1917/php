<?php

declare(strict_types=1);

namespace App\Http;

final class Response {
    /** @var array<string,string> */
    private readonly array $headers;
    /** @param array<string,string> $headers */
    public function __construct(
        private readonly string $content = '',
        private readonly int $statusCode = 200,
        array $headers = [],
    ) {
        $this->headers = $headers !== [] ? $headers : ['Content-Type' => 'text/html; charset=UTF-8'];
    }
    public function send(): void {
        if (!headers_sent()) {
            http_response_code($this->statusCode);

            foreach ($this->headers as $name => $value) {
                header(sprintf('%s: %s', $name, $value));
            }
        }
        echo $this->content;
    }
    public function content(): string {
        return $this->content;
    }
    public function statusCode(): int {
        return $this->statusCode;
    }
    /** @return array<string,string> */
    public function headers(): array {
        return $this->headers;
    }
}
