<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/auth.php';
require_admin();

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// ====== DELETE ======
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int) ($_POST['id'] ?? 0);

    $st = $pdo->prepare("DELETE FROM `услуги` WHERE `id_услуги`=?");
    $st->execute([$id]);

    header('Location: /admin/services.php');
    exit;
}

// ====== SAVE (ADD/EDIT) ======
if (($action === 'add' || $action === 'edit') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $name = trim((string) ($_POST['Название'] ?? ''));
    $desc = trim((string) ($_POST['Описание'] ?? ''));
    $price = (float) ($_POST['Цена'] ?? 0);
    $photo = trim((string) ($_POST['Фото_услуги'] ?? ''));
    $cat = trim((string) ($_POST['Категория'] ?? ''));
    $status = $_POST['Статус'] ?? 'active';
    $perfId = ($_POST['id_исполнителя'] ?? '') !== '' ? (int) $_POST['id_исполнителя'] : null;

    if ($name === '' || $price <= 0) {
        // если ошибка — НЕ редиректим, а покажем сообщение ниже в HTML
        $formError = 'Название и цена обязательны';
    } else {
        if ($action === 'add') {
            $st = $pdo->prepare("
                INSERT INTO `услуги`
                (`Название`,`Описание`,`Цена`,`Фото_услуги`,`id_исполнителя`,`Категория`,`Статус`)
                VALUES (?,?,?,?,?,?,?)
            ");
            $st->execute([$name, $desc ?: null, $price, $photo ?: null, $perfId, $cat ?: null, $status]);
        } else {
            $st = $pdo->prepare("
                UPDATE `услуги` SET
                `Название`=?,`Описание`=?,`Цена`=?,`Фото_услуги`=?,`id_исполнителя`=?,`Категория`=?,`Статус`=?
                WHERE `id_услуги`=?
            ");
            $st->execute([$name, $desc ?: null, $price, $photo ?: null, $perfId, $cat ?: null, $status, $id]);
        }

        header('Location: /admin/services.php');
        exit;
    }
}

require_once __DIR__ . '/layout_top.php';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// список исполнителей для выпадашки
$performers = $pdo->query("SELECT `id_исполнителя`, CONCAT(`Фамилия`,' ',`Имя`) AS fio FROM `исполнитель` ORDER BY `Фамилия`,`Имя`")->fetchAll();

function h($s)
{
    return htmlspecialchars((string) $s, ENT_QUOTES);
}

// DELETE
if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int) ($_POST['id'] ?? 0);
    $st = $pdo->prepare("DELETE FROM `услуги` WHERE `id_услуги`=?");
    $st->execute([$id]);
    header('Location: /admin/services.php');
    exit;
}

// SAVE (add/edit)
if (($action === 'add' || $action === 'edit') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $name = trim((string) ($_POST['Название'] ?? ''));
    $desc = trim((string) ($_POST['Описание'] ?? ''));
    $price = (float) ($_POST['Цена'] ?? 0);
    $photo = trim((string) ($_POST['Фото_услуги'] ?? ''));
    $cat = trim((string) ($_POST['Категория'] ?? ''));
    $status = $_POST['Статус'] ?? 'active';
    $perfId = $_POST['id_исполнителя'] !== '' ? (int) $_POST['id_исполнителя'] : null;

    if ($name === '' || $price <= 0) {
        echo '<div class="alert">Название и цена обязательны</div>';
    } else {
        if ($action === 'add') {
            $st = $pdo->prepare("
        INSERT INTO `услуги`
          (`Название`,`Описание`,`Цена`,`Фото_услуги`,`id_исполнителя`,`Категория`,`Статус`)
        VALUES
          (?,?,?,?,?,?,?)
      ");
            $st->execute([$name, $desc ?: null, $price, $photo ?: null, $perfId, $cat ?: null, $status]);
        } else {
            $st = $pdo->prepare("
        UPDATE `услуги` SET
          `Название`=?,`Описание`=?,`Цена`=?,`Фото_услуги`=?,`id_исполнителя`=?,`Категория`=?,`Статус`=?
        WHERE `id_услуги`=?
      ");
            $st->execute([$name, $desc ?: null, $price, $photo ?: null, $perfId, $cat ?: null, $status, $id]);
        }

        header('Location: /admin/services.php');
        exit;
    }
}

// FORM data for edit
$service = [
    'Название' => '',
    'Описание' => '',
    'Цена' => '',
    'Фото_услуги' => '',
    'id_исполнителя' => '',
    'Категория' => '',
    'Статус' => 'active'
];

if ($action === 'edit') {
    $st = $pdo->prepare("SELECT * FROM `услуги` WHERE `id_услуги`=?");
    $st->execute([$id]);
    $service = $st->fetch();
    if (!$service) {
        echo "<div class='alert'>Услуга не найдена</div>";
        $action = 'list';
    }
}

// VIEW: add/edit form
if ($action === 'add' || $action === 'edit'):
    ?>
    <h2><?= $action === 'add' ? 'Добавить услугу' : 'Редактировать услугу #' . $id ?></h2>

    <form method="post" class="form">
        <div class="row">
            <label>Название *</label>
            <input name="Название" value="<?= h($service['Название']) ?>" required>
        </div>

        <div class="row">
            <label>Описание</label>
            <textarea name="Описание" rows="4"><?= h($service['Описание']) ?></textarea>
        </div>

        <div class="row">
            <label>Цена *</label>
            <input name="Цена" type="number" step="0.01" value="<?= h($service['Цена']) ?>" required>
        </div>

        <div class="row">
            <label>Фото_услуги (URL)</label>
            <input name="Фото_услуги" value="<?= h($service['Фото_услуги']) ?>">
        </div>

        <div class="row">
            <label>Категория</label>
            <input name="Категория" value="<?= h($service['Категория']) ?>" placeholder="surveillance / check / cyber ...">
        </div>

        <div class="row">
            <label>Исполнитель</label>
            <select name="id_исполнителя">
                <option value="">— не назначен —</option>
                <?php foreach ($performers as $p): ?>
                    <option value="<?= (int) $p['id_исполнителя'] ?>" <?= ((string) $service['id_исполнителя'] === (string) $p['id_исполнителя']) ? 'selected' : '' ?>>
                        <?= h($p['fio']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <label>Статус</label>
            <select name="Статус">
                <option value="active" <?= $service['Статус'] === 'active' ? 'selected' : '' ?>>active</option>
                <option value="inactive" <?= $service['Статус'] === 'inactive' ? 'selected' : '' ?>>inactive</option>
            </select>
        </div>

        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
        <div class="actions">
            <button class="btn" type="submit">Сохранить</button>
            <a class="btn secondary" href="/admin/services.php">Отмена</a>
        </div>
    </form>

    <?php
    require_once __DIR__ . '/layout_bottom.php';
    exit;
endif;

// LIST
$q = trim((string) ($_GET['q'] ?? ''));
$params = [];
$sql = "SELECT u.* FROM `услуги` u";
if ($q !== '') {
    $sql .= " WHERE u.`Название` LIKE ? OR u.`Категория` LIKE ?";
    $params = ["%$q%", "%$q%"];
}
$sql .= " ORDER BY u.`id_услуги` DESC";
$st = $pdo->prepare($sql);
$st->execute($params);
$rows = $st->fetchAll();
?>

<h2>Услуги</h2>

<div class="toolbar">
    <a class="btn" href="/admin/services.php?action=add">+ Добавить услугу</a>

    <form method="get" class="search">
        <input name="q" value="<?= h($q) ?>" placeholder="поиск по названию/категории">
        <button class="btn secondary">Найти</button>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= (int) $r['id_услуги'] ?></td>
                <td>
                    <div class="title"><?= h($r['Название']) ?></div>
                    <div class="muted"><?= h($r['Описание']) ?></div>
                </td>
                <td><?= number_format((float) $r['Цена'], 2, '.', ' ') ?></td>
                <td><?= h($r['Категория']) ?></td>
                <td><?= h($r['Статус']) ?></td>
                <td class="td-actions">
                    <a class="btn small" href="/admin/services.php?action=edit&id=<?= (int) $r['id_услуги'] ?>">Ред.</a>

                    <form method="post" action="/admin/services.php?action=delete"
                        onsubmit="return confirm('Удалить услугу?')" style="display:inline">
                        <input type="hidden" name="id" value="<?= (int) $r['id_услуги'] ?>">
                        <input type="hidden" name="csrf" value="<?= h(csrf_token()) ?>">
                        <button class="btn small danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/layout_bottom.php'; ?>