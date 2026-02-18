<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;

final class StatisticsController extends Controller
{
    public function index(): void
    {
        $this->requireMethod('GET');

        $orders = (int) ($this->pdo->query("SELECT COUNT(*) AS c FROM `заказ`")->fetch()['c'] ?? 0);
        $clients = (int) ($this->pdo->query("SELECT COUNT(*) AS c FROM `клиент` WHERE `Статус`='active'")->fetch()['c'] ?? 0);

        Response::ok([
            'data' => [
                'completedCases' => $orders,
                'happyClients' => $clients,
                'yearsExperience' => 5,
                'successRate' => 97
            ]
        ]);
    }
}
