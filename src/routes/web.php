<?php

declare(strict_types=1);

return [
  ['url' => '/', 'method' => 'GET', 'handler' => fn() => 'Домашняя страница'],
  ['url' => '/about', 'method' => 'GET', 'handler' => fn() => 'О нас'],
  ['url' => '/shop', 'method' => 'GET', 'handler' => fn() => 'Магазин'],
];
