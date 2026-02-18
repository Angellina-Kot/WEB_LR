<?php
// admin/auth.php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();

function require_admin(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}
