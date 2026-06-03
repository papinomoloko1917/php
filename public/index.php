<?php

declare(strict_types=1);

use App\Calculator;
use App\View;

define('APP_PATH', dirname(__DIR__));

require APP_PATH . '/vendor/autoload.php';

$calculatePage = new View();
echo $calculatePage->page();

if ($_SERVER['REQUEST_URI'] === '/calculate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation'];
    $num1 = floatval($_POST['num1']);
    $num2 = floatval($_POST['num2']);
    $calculate = new Calculator($operation, $num1, $num2);
    echo $calculate->calculate();
}
