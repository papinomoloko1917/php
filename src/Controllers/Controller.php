<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;
use App\View\ViewRenderer;
use RuntimeException;

abstract class Controller {
    public function __construct(
        private readonly ?ViewRenderer $viewRenderer = null
    ) {
    }
    protected function view(
        string $template,
        array $data = [],
        string $layout = 'app',
        int $statusCode = 200,
        array $headers = []
    ): Response {
        $renderer = $this->viewRenderer ?? new ViewRenderer();

        $content = $renderer->render($template, $data, $layout);

        return new Response($content, $statusCode, $headers);
    }
}
