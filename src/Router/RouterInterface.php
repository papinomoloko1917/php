<?php

declare(strict_types=1);

namespace App\Router;

use App\Route\Route;

interface RouterInterface
{
  public function resolve(): Route;
}
