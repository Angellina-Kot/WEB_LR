<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class AdminController extends Controller
{
    public function checkSession(): void
    {
        $this->requireMethod('GET');

        $isAdmin = isset($_SESSION['admin_id']) && (int) $_SESSION['admin_id'] > 0;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['isAdmin' => $isAdmin], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
