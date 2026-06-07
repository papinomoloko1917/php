<?php

declare(strict_types=1);

use App\Database\Database;
use App\Product\Product;
use App\View\View;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$db = Database::fromEnv();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/add_product') {
    $product = new Product($db);
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = (float)$_POST['price'] ?? '';
    $product->addProduct($title, $description, $price);
}

$view = new View();

echo $view->page('home', ['title' => 'Главная страница']);
