<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/auth.php';
require_admin();

/**
 * Определяем, где лежат позиции заказа:
 * 1) позиции_заказа (предпочтительно) c колонкой id_заказа
 * 2) состав_заказа c колонкой id_заказа
 * 3) иначе — позиций нет / нет связи
 */

function table_exists(PDO $pdo, string $table): bool
{
    $st = $pdo->prepare("SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? LIMIT 1");
    $st->execute([$table]);
    return (bool) $st->fetchColumn();
}

function column_exists(PDO $pdo, string $table, string $column): bool
{
    $st = $pdo->prepare("SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1");
    $st->execute([$table, $column]);
    return (bool) $st->fetchColumn();
}

function h($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES);
}

$itemsTable = null; // 'позиции_заказа' или 'состав_заказа'
if (table_exists($pdo, 'позиции_заказа') && column_exists($pdo, 'позиции_заказа', 'id_заказа')) {
    $itemsTable = 'позиции_заказа';
} elseif (table_exists($pdo, 'состав_заказа') && column_exists($pdo, 'состав_заказа', 'id_заказа')) {
    $itemsTable = 'состав_заказа';
}

/* =======================
   POST: обновление заказа
   ======================= */
if (($_POST['action'] ?? '') === 'order_update') {
    csrf_check();

    $orderId = (int) ($_POST['id_заказа'] ?? 0);
    $status = trim((string) ($_POST['Статус'] ?? 'новый'));
    $address = trim((string) ($_POST['Адрес_исполнения'] ?? ''));
    $comment = trim((string) ($_POST['Комментарий'] ?? ''));
    $dateExec = trim((string) ($_POST['Дата_исполнения'] ?? ''));

    // пустые -> NULL
    $address = ($address !== '') ? $address : null;
    $comment = ($comment !== '') ? $comment : null;
    $dateExec = ($dateExec !== '') ? $dateExec : null;

    $st = $pdo->prepare("
    UPDATE `заказ`
    SET `Статус` = ?,
        `Адрес_исполнения` = ?,
        `Комментарий` = ?,
        `Дата_исполнения` = ?
    WHERE `id_заказа` = ?
  ");
    $st->execute([$status, $address, $comment, $dateExec, $orderId]);

    header('Location: /admin/orders.php');
    exit;
}

/* =========================
   POST: обновить количество
   (если есть таблица позиций)
   ========================= */
if (($_POST['action'] ?? '') === 'item_update_qty') {
    csrf_check();

    $orderId = (int) ($_POST['id_заказа'] ?? 0);
    $itemId = (int) ($_POST['item_id'] ?? 0);
    $qty = max(1, (int) ($_POST['Количество'] ?? 1));

    if ($itemsTable) {
        if ($itemsTable === 'позиции_заказа') {
            // ожидаемые поля: id (или id_позиции) могут отличаться — поддержим оба варианта
            // 1) если есть id_позиции
            if (column_exists($pdo, 'позиции_заказа', 'id_позиции')) {
                $st = $pdo->prepare("UPDATE `позиции_заказа` SET `Количество`=? WHERE `id_позиции`=? AND `id_заказа`=?");
                $st->execute([$qty, $itemId, $orderId]);
            } else {
                // fallback: если PK называется по-другому, используем id (часто так)
                $st = $pdo->prepare("UPDATE `позиции_заказа` SET `Количество`=? WHERE `id`=? AND `id_заказа`=?");
                $st->execute([$qty, $itemId, $orderId]);
            }
        } else {
            // состав_заказа: PK id_Состава_заказа, и там должны быть поля Количество/Цена
            $st = $pdo->prepare("UPDATE `состав_заказа` SET `Количество`=? WHERE `id_Состава_заказа`=? AND `id_заказа`=?");
            $st->execute([$qty, $itemId, $orderId]);
        }

        // Пересчёт итоговой суммы заказа (по БД)
        recalc_order_total($pdo, $itemsTable, $orderId);

        header('Location: /admin/orders.php#order-' . $orderId);
        exit;
    }

    header('Location: /admin/orders.php');
    exit;
}

/* =========================
   POST: удалить позицию
   ========================= */
if (($_POST['action'] ?? '') === 'item_delete') {
    csrf_check();

    $orderId = (int) ($_POST['id_заказа'] ?? 0);
    $itemId = (int) ($_POST['item_id'] ?? 0);

    if ($itemsTable) {
        if ($itemsTable === 'позиции_заказа') {
            if (column_exists($pdo, 'позиции_заказа', 'id_позиции')) {
                $st = $pdo->prepare("DELETE FROM `позиции_заказа` WHERE `id_позиции`=? AND `id_заказа`=?");
                $st->execute([$itemId, $orderId]);
            } else {
                $st = $pdo->prepare("DELETE FROM `позиции_заказа` WHERE `id`=? AND `id_заказа`=?");
                $st->execute([$itemId, $orderId]);
            }
        } else {
            $st = $pdo->prepare("DELETE FROM `состав_заказа` WHERE `id_Состава_заказа`=? AND `id_заказа`=?");
            $st->execute([$itemId, $orderId]);
        }

        recalc_order_total($pdo, $itemsTable, $orderId);
    }

    header('Location: /admin/orders.php#order-' . $orderId);
    exit;
}

/* =========================
   helper: пересчитать итог
   ========================= */
function recalc_order_total(PDO $pdo, string $itemsTable, int $orderId): void
{
    if ($itemsTable === 'позиции_заказа') {
        // варианты колонок:
        // - Цена_единицы / Сумма
        // - Цена / Количество (как в состав_заказа)
        $hasSum = column_exists($pdo, 'позиции_заказа', 'Сумма');
        $hasUnit = column_exists($pdo, 'позиции_заказа', 'Цена_единицы');

        if ($hasSum) {
            $st = $pdo->prepare("SELECT COALESCE(SUM(`Сумма`),0) FROM `позиции_заказа` WHERE `id_заказа`=?");
            $st->execute([$orderId]);
            $total = (float) $st->fetchColumn();
        } elseif ($hasUnit) {
            $st = $pdo->prepare("SELECT COALESCE(SUM(`Цена_единицы` * `Количество`),0) FROM `позиции_заказа` WHERE `id_заказа`=?");
            $st->execute([$orderId]);
            $total = (float) $st->fetchColumn();
        } else {
            // fallback
            $st = $pdo->prepare("SELECT COALESCE(SUM(`Цена` * `Количество`),0) FROM `позиции_заказа` WHERE `id_заказа`=?");
            $st->execute([$orderId]);
            $total = (float) $st->fetchColumn();
        }

        $up = $pdo->prepare("UPDATE `заказ` SET `Итоговая_сумма`=? WHERE `id_заказа`=?");
        $up->execute([$total, $orderId]);
        return;
    }

    // состав_заказа
    $st = $pdo->prepare("SELECT COALESCE(SUM(`Цена` * `Количество`),0) FROM `состав_заказа` WHERE `id_заказа`=?");
    $st->execute([$orderId]);
    $total = (float) $st->fetchColumn();

    $up = $pdo->prepare("UPDATE `заказ` SET `Итоговая_сумма`=? WHERE `id_заказа`=?");
    $up->execute([$total, $orderId]);
    return;
}

/* =========================
   Дальше — HTML (вывод)
   ========================= */

require_once __DIR__ . '/layout_top.php';

// список заказов
$orders = $pdo->query("
  SELECT z.*,
         c.`Фамилия` AS c_last, c.`Имя` AS c_name, c.`email` AS c_email, c.`Телефон` AS c_phone
  FROM `заказ` z
  LEFT JOIN `клиент` c ON c.`id_клиента` = z.`id_клиента`
  ORDER BY z.`id_заказа` DESC
")->fetchAll();

?>
<h2>Заказы</h2>

<?php if (!$itemsTable): ?>
      <div class="alert" style="margin-bottom:12px">
        <b>Состав заказа не связан с заказом.</b><br>
        Чтобы раскрытие работало, нужна таблица позиций с колонкой <code>id_заказа</code>:
        <ul style="margin:8px 0 0 18px">
          <li><code>позиции_заказа</code> (рекомендуется) или</li>
          <li><code>состав_заказа</code> с колонкой <code>id_заказа</code></li>
        </ul>
        Если скажешь, какая таблица у тебя фактически для позиций — подстрою под неё 1-в-1.
      </div>
<?php endif; ?>

<?php foreach ($orders as $o): ?>
      <?php
      $orderId = (int) $o['id_заказа'];
      $clientName = trim(($o['c_last'] ?? '') . ' ' . ($o['c_name'] ?? ''));
      $clientEmail = (string) ($o['c_email'] ?? '');
      $clientPhone = (string) ($o['c_phone'] ?? '');

      // позиции
      $items = [];
      if ($itemsTable === 'позиции_заказа') {
          // под разные структуры: пробуем выбрать часто встречающиеся поля
          $cols = $pdo->query("SHOW COLUMNS FROM `позиции_заказа`")->fetchAll();
          $colNames = array_map(fn($r) => $r['Field'], $cols);

          $pk = in_array('id_позиции', $colNames, true) ? 'id_позиции' : (in_array('id', $colNames, true) ? 'id' : null);
          $hasUnit = in_array('Цена_единицы', $colNames, true);
          $hasSum = in_array('Сумма', $colNames, true);

          // базовый select
          $select = "SELECT * FROM `позиции_заказа` WHERE `id_заказа`=? ORDER BY " . ($pk ? "`$pk` ASC" : "1");
          $st = $pdo->prepare($select);
          $st->execute([$orderId]);
          $items = $st->fetchAll();

          // нормализуем для вывода
          $norm = [];
          foreach ($items as $it) {
              $itemId = $pk ? (int) $it[$pk] : 0;
              $qty = (int) ($it['Количество'] ?? 1);
              $name = (string) ($it['Название_услуги'] ?? $it['name'] ?? 'Позиция');
              $unit = $hasUnit ? (float) $it['Цена_единицы'] : (float) ($it['Цена'] ?? 0);
              $sum = $hasSum ? (float) $it['Сумма'] : ($unit * $qty);
              $norm[] = ['item_id' => $itemId, 'name' => $name, 'qty' => $qty, 'unit' => $unit, 'sum' => $sum];
          }
          $items = $norm;
      } elseif ($itemsTable === 'состав_заказа') {
          $st = $pdo->prepare("
        SELECT `id_Состава_заказа` AS item_id, `Название_услуги` AS name, `Количество` AS qty, `Цена` AS unit,
               (`Цена` * `Количество`) AS sum
        FROM `состав_заказа`
        WHERE `id_заказа`=?
        ORDER BY `id_Состава_заказа` ASC
      ");
          $st->execute([$orderId]);
          $items = $st->fetchAll();
      }
      ?>

      <div class="card" id="order-<?= $orderId ?>" style="margin:12px 0">
        <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap">
          <div>
            <div class="title">Заказ #<?= $orderId ?></div>
            <div class="muted">
              Дата: <?= h($o['Дата_заказа'] ?? '') ?> •
              Клиент: <?= h($clientName ?: '—') ?>
              <?php if ($clientEmail): ?> • <?= h($clientEmail) ?><?php endif; ?>
              <?php if ($clientPhone): ?> • <?= h($clientPhone) ?><?php endif; ?>
            </div>
          </div>
          <div style="text-align:right">
            <div><b><?= number_format((float) $o['Итоговая_сумма'], 2, '.', ' ') ?> ₽</b></div>
            <div class="muted">Статус: <?= h($o['Статус'] ?? 'новый') ?></div>
          </div>
        </div>

        <!-- Редактирование заказа -->
        <details style="margin-top:10px">
          <summary style="cursor:pointer; color:var(--accent); font-weight:800;">Редактировать заказ</summary>
          <form method="post" class="form" style="margin-top:10px">
            <input type="hidden" name="action" value="order_update">
            <input type="hidden" name="id_заказа" value="<?= $orderId ?>">
            <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">

            <div class="row">
              <label>Статус</label>
              <input name="Статус" value="<?= h($o['Статус'] ?? 'новый') ?>" placeholder="новый / в работе / выполнен / отменён">
            </div>

            <div class="row">
              <label>Адрес исполнения</label>
              <textarea name="Адрес_исполнения" rows="2"><?= h($o['Адрес_исполнения'] ?? '') ?></textarea>
            </div>

            <div class="row">
              <label>Комментарий</label>
              <textarea name="Комментарий" rows="3"><?= h($o['Комментарий'] ?? '') ?></textarea>
            </div>

            <div class="row">
              <label>Дата исполнения</label>
              <input type="date" name="Дата_исполнения" value="<?= h($o['Дата_исполнения'] ?? '') ?>">
            </div>

            <div class="actions">
              <button class="btn" type="submit">Сохранить</button>
            </div>
          </form>
        </details>

        <!-- Состав заказа -->
        <details style="margin-top:10px" <?= $itemsTable ? '' : 'disabled' ?>>
          <summary style="cursor:pointer; color:var(--accent); font-weight:800;">
            Состав заказа (<?= $itemsTable ? count($items) : 0 ?>)
          </summary>

          <?php if (!$itemsTable): ?>
                <div class="muted" style="margin-top:8px">Нет связанной таблицы позиций.</div>
          <?php else: ?>

                <?php if (count($items) === 0): ?>
                      <div class="muted" style="margin-top:8px">Позиции не найдены.</div>
                <?php else: ?>
                      <table class="table" style="margin-top:10px">
                        <thead>
                          <tr>
                            <th>Услуга</th>
                            <th>Кол-во</th>
                            <th>Цена</th>
                            <th>Сумма</th>
                            <th>Действия</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($items as $it): ?>
                                <tr>
                                  <td><?= h($it['name']) ?></td>
                                  <td style="width:160px">
                                    <form method="post" style="display:flex; gap:8px; align-items:center">
                                      <input type="hidden" name="action" value="item_update_qty">
                                      <input type="hidden" name="id_заказа" value="<?= $orderId ?>">
                                      <input type="hidden" name="item_id" value="<?= (int) $it['item_id'] ?>">
                                      <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
                                      <input name="Количество" type="number" min="1" value="<?= (int) $it['qty'] ?>" style="width:80px">
                                      <button class="btn small secondary" type="submit">OK</button>
                                    </form>
                                  </td>
                                  <td><?= number_format((float) $it['unit'], 2, '.', ' ') ?> ₽</td>
                                  <td><b><?= number_format((float) $it['sum'], 2, '.', ' ') ?> ₽</b></td>
                                  <td style="white-space:nowrap">
                                    <form method="post" onsubmit="return confirm('Удалить позицию?')" style="display:inline">
                                      <input type="hidden" name="action" value="item_delete">
                                      <input type="hidden" name="id_заказа" value="<?= $orderId ?>">
                                      <input type="hidden" name="item_id" value="<?= (int) $it['item_id'] ?>">
                                      <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
                                      <button class="btn small danger" type="submit">Удалить</button>
                                    </form>
                                  </td>
                                </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>

                      <!-- <div class="muted" style="margin-top:8px">
                        Итог заказа пересчитывается автоматически при изменении количества/удалении позиции.
                      </div> -->
                <?php endif; ?>

          <?php endif; ?>
        </details>

      </div>
<?php endforeach; ?>

<?php require_once __DIR__ . '/layout_bottom.php'; ?>
