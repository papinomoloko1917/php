<?php

declare(strict_types=1);

use App\Database\Database;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$database = Database::fromEnv();

$conn = $database->conn();
