<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ServiceRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findActive(string $category, int $limit, int $offset): array
    {
        $where = "WHERE `Статус`='active'";
        $params = [];

        if ($category !== '' && $category !== 'all') {
            $where .= " AND `Категория` = :cat";
            $params[':cat'] = $category;
        }

        $st = $this->pdo->prepare("SELECT COUNT(*) AS c FROM `услуги` {$where}");
        $st->execute($params);
        $total = (int) ($st->fetch()['c'] ?? 0);

        $sql = "
      SELECT `id_услуги`, `Название`, `Описание`, `Цена`, `Фото_услуги`, `Категория`, `id_исполнителя`
      FROM `услуги`
      {$where}
      ORDER BY `Дата_добавления` DESC, `id_услуги` DESC
      LIMIT :lim OFFSET :off
    ";
        $st = $this->pdo->prepare($sql);
        foreach ($params as $k => $v)
            $st->bindValue($k, $v);
        $st->bindValue(':lim', $limit, PDO::PARAM_INT);
        $st->bindValue(':off', $offset, PDO::PARAM_INT);
        $st->execute();

        return ['total' => $total, 'rows' => $st->fetchAll()];
    }

    public function categories(): array
    {
        $st = $this->pdo->query("
      SELECT DISTINCT `Категория` AS category
      FROM `услуги`
      WHERE `Статус`='active' AND `Категория` IS NOT NULL AND TRIM(`Категория`) <> ''
      ORDER BY category ASC
    ");
        return array_map(fn($r) => (string) $r['category'], $st->fetchAll());
    }
}
