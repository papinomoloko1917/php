<?php

use App\Support\Env;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$filePath = APP_PATH . '/.testFile';

Env::write($filePath);
