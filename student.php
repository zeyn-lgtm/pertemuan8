<?php
class StudentPresenter {
    public function __call(string $name, array $args): string
    {
        if ($name !== 'showData') {
            throw new BadMethodCallException('Unknown method: ' . $name);
        }

        foreach ($args as $arg) {
            if (!is_string($arg)) {
                throw new InvalidArgumentException('All arguments must be strings');
            }
        }

        return match (count($args)) {
            1 => 'Name: ' . $args[0],
            2 => 'ID: ' . $args[0] . ', Name: ' . $args[1],
            3 => 'ID: ' . $args[0] . ', Name: ' . $args[1] . ', Major: ' . $args[2],
            default => throw new InvalidArgumentException('Expected 1, 2, or 3 strings'),
        };
    }
}

$view = new StudentPresenter();
try {
    echo $view->showData('Ahmad') . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

try {
    echo $view->showData('2026001', 'Ahmad') . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
try {
    echo $view->showData('2026001', 'Ahmad', 'Informatika') . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

try {
    echo $view->showData() . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

try {
    echo $view->showData(123) . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

try {
    echo $view->showData('a', 'b', 'c', 'd') . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
try {
    echo $view->hapusData('x') . "<br>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

?>
