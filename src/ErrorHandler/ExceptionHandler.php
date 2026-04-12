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
        [$statusCode, $view] = $this->resolveError($e);

        http_response_code($statusCode);

        $message = $this->debug ? $e->getMessage() : null;

        $exception = $this->debug ? $e : null;

        $this->render($view, [
            'message' => $message,
            'exception' => $exception,
        ]);
    }
    private function resolveError(Throwable $e): array {
        return match (true) {
            $e instanceof RouteNotFoundException => [404, 'errors/404'],
            $e instanceof MethodNotAllowedException => [405, 'errors/405'],
            default => [500, 'errors/500'],
        };
    }
    /** *@param array <string, mixed> $data */
    private function render(string $view, array $data = []): void {
        $viewPath = dirname(__DIR__, 2) . '/resources/views/' . $view . '.php';
        require $viewPath;
    }
}
