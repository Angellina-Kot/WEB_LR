<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $login = trim((string) ($_POST['login'] ?? ''));
    $pass = (string) ($_POST['password'] ?? '');

    $st = $pdo->prepare("SELECT * FROM `администраторы` WHERE `Логин`=? AND `Статус`='active' LIMIT 1");
    $st->execute([$login]);
    $admin = $st->fetch();

    if (!$admin || !password_verify($pass, $admin['Пароль'])) {
        $error = 'Неверный логин или пароль';
    } else {
        $_SESSION['admin_id'] = (int) $admin['id_администратора'];
        $_SESSION['admin_role'] = (string) $admin['Уровень_доступа'];
        $_SESSION['admin_name'] = trim(($admin['Имя'] ?? '') . ' ' . ($admin['Фамилия'] ?? ''));
        header('Location: /admin/dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/admin/admin.css">
 <link rel="icon" href="/favicon.ico?v=2">
</head>
<body class="auth">
  <form method="post" class="auth-box">
    <h1>Adrasteia Admin</h1>

    <?php if ($error): ?>
          <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <input name="login" type="text" placeholder="Логин" required>
    <input name="password" type="password" placeholder="Пароль" required>
    <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">

    <button type="submit">Войти</button>
  </form>
</body>
</html>
