<?php

declare(strict_types=1);

namespace App;

class Calculator
{
    public function __construct(
        private string $operation,
        private float $num1,
        private float $num2,
    ) {

    }
    public function calculate(): float
    {
        $sum = 0;
        switch ($this->operation) {
            case '+':
                $sum  = $this->num1 + $this->num2;
                break;
            case '-':
                $sum  = $this->num1 - $this->num2;
                break;
        }
        return $sum;

    }
}
