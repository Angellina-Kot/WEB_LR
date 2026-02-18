<?php
declare(strict_types=1);

namespace App\Core;

final class Cookie
{
    public static function set(string $name, string $value, int $days = 7, array $opts = []): void
    {
        $ttl = $days * 24 * 60 * 60;

        setcookie($name, $value, [
            'expires' => time() + $ttl,
            'path' => $opts['path'] ?? '/',
            'secure' => (bool) ($opts['secure'] ?? false),  // true на HTTPS
            'httponly' => (bool) ($opts['httponly'] ?? false),// можно false, т.к. нужно JS? (но мы читаем в PHP)
            'samesite' => (string) ($opts['samesite'] ?? 'Lax'),
        ]);
    }

    public static function get(string $name, string $default = ''): string
    {
        return isset($_COOKIE[$name]) ? (string) $_COOKIE[$name] : $default;
    }

    public static function delete(string $name, array $opts = []): void
    {
        setcookie($name, '', [
            'expires' => time() - 3600,
            'path' => $opts['path'] ?? '/',
            'secure' => (bool) ($opts['secure'] ?? false),
            'httponly' => (bool) ($opts['httponly'] ?? false),
            'samesite' => (string) ($opts['samesite'] ?? 'Lax'),
        ]);
    }
}
