<?php

namespace App;

use App\Router;

class App
{
    private string $url;
    private string $page_dir;

    public function __construct(string $url, string $page_dir)
    {
        $this->url = $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->page_dir = $page_dir = __DIR__ . '/pages';
    }

    public static function run()
    {
        echo '111';
    }
}
