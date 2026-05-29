<?php

declare(strict_types=1);

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

use App\App;
use App\Container\Container;

$container = new Container();

$app = new App($container);

$app->run();
