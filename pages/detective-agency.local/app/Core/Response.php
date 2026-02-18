<?php
declare(strict_types=1);

namespace App\Core;

final class Response
{
    public static function ok(array $payload = []): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true] + $payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public static function fail(string $message, int $code = 400, array $extra = []): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => false, 'message' => $message] + $extra, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
