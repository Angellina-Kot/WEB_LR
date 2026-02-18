<?php
function printNameNTimes($surname, $name, $times)
{
    $i = 0;
    do {
        echo $surname . " " . $name . "<br>";
        $i++;
    } while ($i < $times);
}
