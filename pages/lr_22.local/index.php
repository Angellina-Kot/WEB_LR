<?php
declare(strict_types=1);

//Подключение файлов
include __DIR__ . '/2_date_utils.php';
include __DIR__ . '/3_loops.php';
include __DIR__ . '/4_arrays.php';
include __DIR__ . '/5_strings.php';
include __DIR__ . '/6_math.php';

$n = 6;
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>PHP ЛР22</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        section {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            margin: 10px;
        }
    </style>
</head>

<body>

    <h1>Основы синтаксиса PHP</h1>

    <section>
        <h2> Номер дня недели по дате</h2>
        <?php
        $date = '2026-02-13';
        $dow = dayOfWeekNumber($date);
        echo "Дата: {$date}<br>";
        echo "Порядковый номер дня недели: {$dow}";
        ?>
    </section>

    <section>
        <h2> Цикл do...while — вывести Фамилию и Имя n+5 раз</h2>
        <?php       
        printNameNTimes("Кот", "Ангелина", $n + 5);
        ?>
    </section>

    <section>
        <h2> Массив из 7 целых элементов, найти — max, удалить последний, вывести</h2>
        <?php
        $result = arrayTask();
        echo "<b>Исходный массив:</b>";
        echo htmlspecialchars(print_r($result['original'], true));

        echo "Максимальный элемент: {$result['max']}<br><br>";

        echo "Изменённый массив (после удаления последнего):";
        echo htmlspecialchars(print_r($result['modified'], true));
        ?>
    </section>

    <section>
        <h2> Строки</h2>
        <?php
        $s1 = "Я люблю Беларусь";
        $s2 = "Я учусь в Политехническом колледже";

        $info = stringTasks($s1, $s2, $n);

        echo "S1:  $s1 <br>";
        echo "S2: $s2 <br>";

        echo "1) Длина строки S2: {$info['len_s2']}<br>";

        echo "2) {$n}-й символ в S1: " . htmlspecialchars($info['nth_char']) . "<br>";
        echo "Код символа: {$info['code_point']}<br>";

        echo "3) Замена «Беларусь» на «Гродно»:" . htmlspecialchars($info['replaced']);
        ?>
    </section>

    <section>
        <h2> Пользовательская функция: y = (6x − 15)/(x − 2)</h2>

        <?php
        $tests = [0, 1, 2, 3, 10];

        echo "<b>Вычисления:</b><br>";
        echo "<ul>";
        foreach ($tests as $x) {
            try {
                $y = calcY($x);
                echo "<li>x = {$x}, y = {$y}</li>";
            } catch (Throwable $e) {
                echo "<li>x = {$x},  Ошибка: " . htmlspecialchars($e->getMessage()) . "</li>";
            }
        }
        echo "</ul>";
        ?>
    </section>

</body>

</html>