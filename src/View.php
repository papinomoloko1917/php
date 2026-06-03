<?php

declare(strict_types=1);

namespace App;

class View
{
    public function page(): string
    {
        ob_start();
        require APP_PATH . '/public/view/pages/calculate.php';
        $content = ob_get_clean();

        ob_start();
        require APP_PATH . '/public/view/layouts/mainLayout.php';
        $layout = ob_get_clean();

        return $layout;
    }
}
