<?php
declare(strict_types=1);
class Calculator {
    public function add(int ...$numbers): int {
        return array_sum($numbers);
    }
}

$calc = new Calculator();
echo $calc->add(10, 20) . PHP_EOL;       // 30
echo $calc->add(10, 20, 30) . PHP_EOL;  // 60