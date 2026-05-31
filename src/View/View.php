<?php

declare(strict_types=1);

namespace App\View;

class View
{
    public function page(string $name, array $data)
    {
        extract($data);

        ob_start();
        require APP_PATH . "/public/view/pages/{$name}.php";
        $content = ob_get_clean();

        ob_start();
        require APP_PATH . "/public/view/layout/mainLayout.php";
        $layout = ob_get_clean();

        return $layout;
    }
}
