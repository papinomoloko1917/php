<?php

declare(strict_types=1);

namespace App\ErrorHandler;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use App\Http\Response;
use App\View\ViewRenderer;
use Throwable;

final class ExceptionHandler {
    public function __construct(
        private readonly bool $debug = false,
        private readonly ?ViewRenderer $viewRenderer = null,
    ) {
    }

    public function handle(Throwable $e): Response {
        [$statusCode, $title] = $this->resolveError($e);

        try {
            $renderer = $this->viewRenderer ?? new ViewRenderer();

            $content = $renderer->render('errors/errorsPage', [
                'title' => $title,
                'message' => $this->debug ? $e->getMessage() : null,
                'file' => $this->debug ? $e->getFile() : null,
                'line' => $this->debug ? $e->getLine() : null,
            ]);

            return new Response($content, $statusCode);
        } catch (Throwable $renderError) {
            $fallback = $this->debug
                ? $title . PHP_EOL . $e->getMessage() . PHP_EOL . $renderError->getMessage()
                : $title;

            return new Response(
                nl2br(htmlspecialchars($fallback, ENT_QUOTES, 'UTF-8')),
                $statusCode
            );
        }
    }

    /**
     * @return array{0: int, 1: string}
     */
    private function resolveError(Throwable $e): array {
        return match (true) {
            $e instanceof RouteNotFoundException => [404, '404 | Not Found'],
            $e instanceof MethodNotAllowedException => [405, '405 | Method Not Allowed'],
            default => [500, '500 | Internal Server Error'],
        };
    }
}
