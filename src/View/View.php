<?php

declare(strict_types=1);

namespace App\View;

class View
{
    public function page(string $template, array $data = []): string
    {
        extract($data);

        ob_start();
        require APP_PATH . "/public/view/pages/$template.php";
        $content = ob_get_clean();

        ob_start();
        require APP_PATH . '/public/view/layouts/mainLayout.php';
        $layout = ob_get_clean();

        return $layout;
    }
}
