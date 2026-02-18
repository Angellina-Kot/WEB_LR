<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout_top.php';
$rows = $pdo->query("SELECT * FROM `исполнитель` ORDER BY `id_исполнителя` DESC")->fetchAll();
?>
<h2>Исполнители</h2>
<table class="table">
  <tr>
    <th>ID</th><th>ФИО</th><th>Email</th><th>Телефон</th><th>Статус</th>
  </tr>
  <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int) $r['id_исполнителя'] ?></td>
          <td><?= htmlspecialchars($r['Фамилия'] . ' ' . $r['Имя'] . ' ' . $r['Отчество']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars($r['Телефон']) ?></td>
          <td><?= htmlspecialchars($r['Статус']) ?></td>
        </tr>
  <?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/layout_bottom.php'; ?>
