<?php
// admin/layout_top.php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';
require_admin();
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin</title>
  <link rel="stylesheet" href="/admin/admin.css">
 <link rel="icon" href="/favicon.ico?v=2">
</head>
<body>
<header class="topbar">
  <div class="brand">Adrasteia Admin</div>
  <div class="who">
    <?= htmlspecialchars($_SESSION['admin_name'] ?: 'Администратор') ?>
    <a class="link" href="/admin/logout.php">Выйти</a>
  </div>
</header>

<nav class="sidebar">
  <a href="/admin/dashboard.php">Панель</a>
  <a href="/admin/services.php">Услуги</a>
  <a href="/admin/performers.php">Исполнители</a>
  <a href="/admin/clients.php">Клиенты</a>
  <a href="/admin/orders.php">Заказы</a>
  <a href="/admin/reviews.php">Отзывы</a>
  <a href="/admin/admins.php">Админы</a>
</nav>

<main class="content">
