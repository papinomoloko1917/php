<?php

use Uri\Rfc3986\Uri;

$url = Uri::parse($_SERVER['REQUEST_URI']);

$path = $url->getPath();

echo $path;
