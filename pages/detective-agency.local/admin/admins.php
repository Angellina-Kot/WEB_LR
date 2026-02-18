<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout_top.php';
$rows = $pdo->query("SELECT `id_администратора`,`Логин`,`email`,`Имя`,`Фамилия`,`Уровень_доступа`,`Статус`,`Дата_создания` FROM `администраторы` ORDER BY `id_администратора` DESC")->fetchAll();
?>
<h2>Администраторы</h2>
<table class="table">
  <tr><th>ID</th><th>Логин</th><th>Email</th><th>Имя</th><th>Роль</th><th>Статус</th><th>Дата</th></tr>
  <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int) $r['id_администратора'] ?></td>
          <td><?= htmlspecialchars($r['Логин']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= htmlspecialchars(trim(($r['Имя'] ?? '') . ' ' . ($r['Фамилия'] ?? ''))) ?></td>
          <td><?= htmlspecialchars($r['Уровень_доступа']) ?></td>
          <td><?= htmlspecialchars($r['Статус']) ?></td>
          <td><?= htmlspecialchars($r['Дата_создания']) ?></td>
        </tr>
  <?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/layout_bottom.php'; ?>
