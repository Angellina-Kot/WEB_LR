<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Controller
{
    public function __construct(protected PDO $pdo, protected Request $req)
    {
    }

    protected function requireMethod(string $method): void
    {
        if ($this->req->method !== strtoupper($method)) {
            Response::fail("Method not allowed. Use {$method}.", 405);
        }
    }
}
