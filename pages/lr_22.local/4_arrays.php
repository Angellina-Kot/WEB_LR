<?php
function arrayTask()
{
    $arr = [5, 12, -3, 8, 0, 7, 19];
    $max = max($arr);
    $modified = $arr;
    array_pop($modified);
    return [
        "original" => $arr,
        "max" => $max,
        "modified" => $modified
    ];
}
