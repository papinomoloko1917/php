<?php

declare(strict_types=1);

use App\App;
use App\Database\Database;
use App\Product\Product;
use App\View\View;
use Uri\Rfc3986\Uri;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$app = new App();
$app->run();
