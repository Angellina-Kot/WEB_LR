<?php
declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function start(array $cfg): void
    {
        if (session_status() === PHP_SESSION_ACTIVE)
            return;

        session_name((string) ($cfg['name'] ?? 'APPSESSID'));

        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => (bool) ($cfg['cookie_secure'] ?? false),
            'httponly' => true,
            'samesite' => (string) ($cfg['cookie_samesite'] ?? 'Lax'),
        ]);

        session_start();
    }

    public static function requireClientId(): int
    {
        $cid = (int) ($_SESSION['client_id'] ?? 0);
        if ($cid <= 0) {
            Response::fail('Unauthorized', 401);
        }
        return $cid;
    }
}
