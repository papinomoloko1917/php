<?php

require_once __DIR__ . '/../bootstrap/app.php';

use App\App;
use App\Router\Router;

$app = new App(new Router());

$app->run();
