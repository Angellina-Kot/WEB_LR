<?php
// Использование предопределённых констант и переменных

echo "Текущий файл: " . __FILE__ . "<br>";
echo "Текущая строка: " . __LINE__ . "<br>";
echo "Версия PHP: " . PHP_VERSION . "<br><br>";

// Суперглобальные переменные
echo "IP пользователя: " . $_SERVER["REMOTE_ADDR"] . "<br>";
echo "Браузер: " . $_SERVER["HTTP_USER_AGENT"] . "<br>";
?>
