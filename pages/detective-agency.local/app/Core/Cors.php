<?php
declare(strict_types=1);

namespace App\Core;

final class Cors
{
    public static function handlePreflight(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
    }
}
