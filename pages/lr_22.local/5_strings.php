<?php
declare(strict_types=1);

function stringTasks(string $s1, string $s2, int $n): array
{
    // Длина строки S2
    $lenS2 = mb_strlen(string: $s2, encoding: 'UTF-8');

    // n-ый символ в S1
    $lenS1 = mb_strlen(string: $s1, encoding: 'UTF-8');

    $nthChar = mb_substr(string: $s1, start: $n - 1, length: 1, encoding: 'UTF-8');

    // ASCII-код
    $codePoint = unicodeCodePoint(char: $nthChar);

    // Замена "Беларусь" -> "Гродно"
    $replaced = str_replace(search: "Беларусь", replace: "Гродно", subject: $s1);

    return [
        'len_s2' => $lenS2,
        'nth_char' => $nthChar,
        'code_point' => $codePoint,
        'replaced' => $replaced,
    ];
}

function unicodeCodePoint(string $char): int
{
    
    $u = mb_convert_encoding(string: $char, to_encoding: 'UCS-4BE', from_encoding: 'UTF-8');
    $arr = unpack(format: 'N', string: $u);
    return (int) $arr[1];
}
