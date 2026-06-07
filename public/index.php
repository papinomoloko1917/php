<?php

declare(strict_types=1);

use App\Database\Database;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$db = Database::fromEnv();

$pdo = $db->conn();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'CREATE TABLE products (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(250) NOT NULL
)';

$pdo->exec($sql);
