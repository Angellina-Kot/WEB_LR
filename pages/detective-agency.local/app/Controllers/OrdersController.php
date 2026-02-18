<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Core\Session;
use App\Repositories\OrderRepository;

final class OrdersController extends Controller
{
    public function create(): void
    {
        $this->requireMethod('POST');

        $clientId = Session::requireClientId();

        $items = $this->req->json['items'] ?? null;
        $address = isset($this->req->json['address']) ? trim((string) $this->req->json['address']) : null;
        $comment = isset($this->req->json['clientComment']) ? trim((string) $this->req->json['clientComment']) : null;

        if (!is_array($items) || count($items) === 0) {
            Response::fail('Корзина пуста');
        }

        $repo = new OrderRepository($this->pdo);

        try {
            $created = $repo->createOrderWithItems($clientId, $items, $address ?: null, $comment ?: null);
            Response::ok(['data' => $created]);
        } catch (\Throwable $e) {
            Response::fail('Ошибка создания заказа', 500, ['details' => $e->getMessage()]);
        }
    }

    public function my(): void
    {
        $this->requireMethod('GET');
        $clientId = Session::requireClientId();

        $repo = new OrderRepository($this->pdo);
        $orders = $repo->findOrdersByClient($clientId);

        Response::ok(['orders' => $orders]);
    }
}
