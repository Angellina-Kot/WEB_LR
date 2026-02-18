<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class TestimonialRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function approved(int $limit = 30): array
    {
        $limit = max(1, min(50, $limit));
        $st = $this->pdo->query("
      SELECT r.`id_отзыва`, r.`Текст`, r.`Оценка`, c.`Имя`, c.`Фамилия`, c.`id_клиента`
      FROM `отзывы` r
      LEFT JOIN `клиент` c ON c.`id_клиента` = r.`id_клиента`
      WHERE r.`Статус`='approved'
      ORDER BY r.`Дата_создания` DESC
      LIMIT {$limit}
    ");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
