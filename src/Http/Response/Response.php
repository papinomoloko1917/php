<?php

declare(strict_types=1);

namespace App\Http\Response;

class Response {
    public function __construct(
        private readonly string $content = '',
        private readonly int $statusCode = 200,
        private readonly array $headers = [],
    ) {
    }
    public function send(): void {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }
    public function content(): string {
        return $this->content;
    }

    public function statusCode(): int {
        return $this->statusCode;
    }

    public function headers(): array {
        return $this->headers;
    }
}
