<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class OrderRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function createOrderWithItems(int $clientId, array $items, ?string $address, ?string $comment): array
    {
        $total = 0.0;
        $clean = [];

        foreach ($items as $it) {
            $serviceId = (int) ($it['serviceId'] ?? 0);
            $qty = (int) ($it['quantity'] ?? 0);
            if ($serviceId <= 0 || $qty <= 0) {
                throw new \RuntimeException('Некорректные позиции в заказе');
            }

            $st = $this->pdo->prepare("SELECT id_услуги, Название, Цена, Статус FROM услуги WHERE id_услуги=? LIMIT 1");
            $st->execute([$serviceId]);
            $srv = $st->fetch(PDO::FETCH_ASSOC);
            if (!$srv)
                throw new \RuntimeException("Услуга #$serviceId не найдена");
            if (($srv['Статус'] ?? 'active') !== 'active')
                throw new \RuntimeException("Услуга '{$srv['Название']}' недоступна");

            $unit = (float) $srv['Цена'];
            $sum = $unit * $qty;
            $total += $sum;

            $clean[] = [
                'serviceId' => (int) $srv['id_услуги'],
                'name' => (string) $srv['Название'],
                'qty' => $qty,
                'unit' => $unit,
                'sum' => $sum
            ];
        }

        $this->pdo->beginTransaction();

        try {
            $st1 = $this->pdo->prepare("
        INSERT INTO заказ (Итоговая_сумма, Статус, Дата_заказа, id_клиента, Комментарий, Адрес_исполнения, Дата_исполнения)
        VALUES (?, 'новый', NOW(), ?, ?, ?, NULL)
      ");
            $st1->execute([$total, $clientId, ($comment ?: null), ($address ?: null)]);
            $orderId = (int) $this->pdo->lastInsertId();

            $st2 = $this->pdo->prepare("
        INSERT INTO позиции_заказа (id_заказа, id_услуги, Название_услуги, Количество, Цена_единицы, Сумма)
        VALUES (?, ?, ?, ?, ?, ?)
      ");
            foreach ($clean as $ci) {
                $st2->execute([$orderId, $ci['serviceId'], $ci['name'], $ci['qty'], $ci['unit'], $ci['sum']]);
            }

            $this->pdo->commit();
            return ['id_заказа' => $orderId, 'итог' => $total];
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction())
                $this->pdo->rollBack();
            throw $e;
        }
    }

    public function findOrdersByClient(int $clientId): array
    {
        $st = $this->pdo->prepare("
      SELECT id_заказа, Итоговая_сумма, Статус, Дата_заказа, Комментарий, Адрес_исполнения
      FROM заказ
      WHERE id_клиента=?
      ORDER BY Дата_заказа DESC, id_заказа DESC
      LIMIT 50
    ");
        $st->execute([$clientId]);
        $orders = $st->fetchAll(PDO::FETCH_ASSOC);
        if (!$orders)
            return [];

        $ids = array_map(fn($o) => (int) $o['id_заказа'], $orders);
        $in = implode(',', array_fill(0, count($ids), '?'));

        $st2 = $this->pdo->prepare("
      SELECT id_заказа, id_услуги, Название_услуги, Количество, Цена_единицы, Сумма
      FROM позиции_заказа
      WHERE id_заказа IN ($in)
      ORDER BY id_позиции ASC
    ");
        $st2->execute($ids);
        $items = $st2->fetchAll(PDO::FETCH_ASSOC);

        $byOrder = [];
        foreach ($items as $it) {
            $oid = (int) $it['id_заказа'];
            $byOrder[$oid][] = [
                'serviceId' => $it['id_услуги'] !== null ? (int) $it['id_услуги'] : null,
                'name' => (string) $it['Название_услуги'],
                'qty' => (int) $it['Количество'],
                'unit' => (float) $it['Цена_единицы'],
                'sum' => (float) $it['Сумма'],
            ];
        }

        return array_map(function ($o) use ($byOrder) {
            $oid = (int) $o['id_заказа'];
            return [
                'id' => $oid,
                'total' => (float) $o['Итоговая_сумма'],
                'status' => (string) ($o['Статус'] ?? 'новый'),
                'date' => $o['Дата_заказа'] ? date('Y-m-d H:i', strtotime($o['Дата_заказа'])) : null,
                'comment' => $o['Комментарий'] ?? '',
                'address' => $o['Адрес_исполнения'] ?? '',
                'items' => $byOrder[$oid] ?? []
            ];
        }, $orders);
    }
}
