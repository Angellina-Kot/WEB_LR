<?php
// Создание константы
define("NUM_E", 2.71828);

// Вывод значения константы
echo "Число e равно " . NUM_E . "<br><br>";

// Присваивание константы переменной
$num_e1 = NUM_E;

// Тип переменной
echo "Тип num_e1: " . gettype($num_e1) . "<br>";

// Преобразование в строку
$num_e1 = (string)$num_e1;
echo "Строка: " . $num_e1 . " (" . gettype($num_e1) . ")<br>";

// Преобразование в целое
$num_e1 = (int)$num_e1;
echo "Целое: " . $num_e1 . " (" . gettype($num_e1) . ")<br>";

// Преобразование в булево
$num_e1 = (bool)$num_e1;
echo "Булево: " . $num_e1 . " (" . gettype($num_e1) . ")<br>";
?>
