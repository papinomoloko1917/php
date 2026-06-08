<?php

declare(strict_types=1);

namespace App;

use App\Container\Container;
use Throwable;

class App
{
    private readonly Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }
    public function run()
    {
        try {
            $existRoute = $this->container->router->handle();
            echo $this->container->dispatcher->dispatch($existRoute);
            // if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/add_product') {
            //     $product = $this->container->product;
            //     $title = $_POST['title'] ?? '';
            //     $description = $_POST['description'] ?? '';
            //     $price = (float)$_POST['price'] ?? '';
            //     $product->addProduct($title, $description, $price);
            // }
            // echo $this->container->view->page('home', ['title' => 'Главная страница']);
        } catch (Throwable $e) {
            echo $e->getMessage();
        }

    }
}
