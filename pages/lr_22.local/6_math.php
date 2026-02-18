<?php
declare(strict_types=1);

function calcY(float|int $x): float
{
    if (!is_numeric(value: $x)) {
        throw new InvalidArgumentException(message: "x должен быть числом");
    }

    $den = $x - 2;
    if ($den == 0.0) {
        throw new DivisionByZeroError(message: "Деление на ноль: (x - 2) = 0 при x = 2");
    }

    $y = (6 * $x - 15) / $den;

    if (!is_finite(num: $y)) {
        throw new RuntimeException(message: "Результат не является конечным числом");
    }

    return $y;
}
