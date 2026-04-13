<?php

declare(strict_types=1);

namespace App\ErrorHandler;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use Throwable;

final class ExceptionHandler {
    public function __construct(
        private readonly bool $debug = false,
    ) {
    }
    public function handle(Throwable $e): void {
        [$statusCode, $title] = $this->resolveError($e);

        http_response_code($statusCode);

        $message = $this->debug ? $e->getMessage() : null;

        $file = $this->debug ? $e->getFile() : null;

        $line = $this->debug ? $e->getLine() : null;

        $exception = $this->debug ? $e : null;

        $this->render($title, [
            'message' => $message,
            'exception' => $exception,
            'file' => $file,
            'line' => $line,
        ]);
    }
    private function resolveError(Throwable $e): array {
        return match (true) {
            $e instanceof RouteNotFoundException => [404, '404 | Not Found'],
            $e instanceof MethodNotAllowedException => [405, '405 | Method Not Allowed'],
            default => [500, '500 | Internal Server Error'],
        };
    }
    /** *@param array <string, mixed> $data */
    private function render(string $title, array $data = []): void {
        $viewPath = dirname(__DIR__, 2) . '/resources/views/errors/errorsPage.php';

        if (!file_exists($viewPath)) {
            echo 'View not found';
            return;
        }

        extract($data, EXTR_SKIP);

        require $viewPath;
    }
}
