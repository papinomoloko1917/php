<?php

declare(strict_types=1);

namespace App\View;

use RuntimeException;
use Throwable;

final class ViewRenderer {
    private readonly string $viewsPath;
    private readonly string $layoutsPath;

    public function __construct(?string $viewsPath = null, ?string $layoutsPath = null) {
        $projectRoot = dirname(__DIR__, 2);

        $this->viewsPath = $viewsPath ?? $projectRoot . '/resources/views';
        $this->layoutsPath = $layoutsPath ?? $projectRoot . '/resources/layouts';
    }

    /**
     * @param array<string, mixed> $data
     */
    public function render(string $template, array $data = [], ?string $layout = 'app'): string {
        $viewPath = $this->resolveViewPath($template);
        $content = $this->renderPhpFile($viewPath, $data);

        if ($layout === null) {
            return $content;
        }

        $layoutPath = $this->resolveLayoutPath($layout);

        return $this->renderPhpFile($layoutPath, array_merge($data, [
            'content' => $content,
        ]));
    }

    private function resolveViewPath(string $template): string {
        $path = $this->viewsPath . '/' . ltrim($template, '/') . '.php';

        if (!is_file($path)) {
            throw new RuntimeException("Шаблон {$template} не найден по пути: {$path}");
        }

        return $path;
    }

    private function resolveLayoutPath(string $layout): string {
        $path = $this->layoutsPath . '/' . ltrim($layout, '/') . '.layout.php';

        if (!is_file($path)) {
            throw new RuntimeException("Layout {$layout} не найден по пути: {$path}");
        }

        return $path;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderPhpFile(string $filePath, array $data = []): string {
        ob_start();

        try {
            extract($data, EXTR_SKIP);
            require $filePath;

            return (string) ob_get_clean();
        } catch (Throwable $e) {
            ob_end_clean();
            throw $e;
        }
    }
}
