<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout_top.php';

$rows = $pdo->query("
  SELECT r.*,
         c.`Фамилия` AS c_last, c.`Имя` AS c_name,
         u.`Название` AS u_name
  FROM `отзывы` r
  LEFT JOIN `клиент` c ON c.`id_клиента` = r.`id_клиента`
  LEFT JOIN `услуги` u ON u.`id_услуги` = r.`id_услуги`
  ORDER BY r.`id_отзыва` DESC
")->fetchAll();
?>
<h2>Отзывы</h2>
<table class="table">
  <tr>
    <th>ID</th><th>Клиент</th><th>Услуга</th><th>Оценка</th><th>Статус</th><th>Текст</th><th>Дата</th>
  </tr>
  <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int) $r['id_отзыва'] ?></td>
          <td><?= htmlspecialchars(trim(($r['c_last'] ?? '') . ' ' . ($r['c_name'] ?? ''))) ?: '—' ?></td>
          <td><?= htmlspecialchars($r['u_name'] ?? '—') ?></td>
          <td><?= htmlspecialchars((string) $r['Оценка']) ?></td>
          <td><?= htmlspecialchars($r['Статус']) ?></td>
          <td><?= htmlspecialchars($r['Текст']) ?></td>
          <td><?= htmlspecialchars($r['Дата_создания']) ?></td>
        </tr>
  <?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/layout_bottom.php'; ?>
