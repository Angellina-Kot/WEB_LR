<?php
// Переменные для оформления текста
$color = "purple";
$size = "24px";

$name = "Кот Ангелина Степановна"; // ФИО разработчика
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Цвет и размер</title>
</head>
<body>
    <p style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>;">
        <?php echo $name; ?>
    </p>
</body>
</html>
