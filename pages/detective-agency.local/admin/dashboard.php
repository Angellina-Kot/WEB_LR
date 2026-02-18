<?php
declare(strict_types=1);
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/layout_top.php';

$cntServices = (int) $pdo->query("SELECT COUNT(*) FROM `услуги`")->fetchColumn();
$cntClients = (int) $pdo->query("SELECT COUNT(*) FROM `клиент`")->fetchColumn();
$cntPerf = (int) $pdo->query("SELECT COUNT(*) FROM `исполнитель`")->fetchColumn();
$cntOrders = (int) $pdo->query("SELECT COUNT(*) FROM `заказ`")->fetchColumn();
$cntReviews = (int) $pdo->query("SELECT COUNT(*) FROM `отзывы`")->fetchColumn();
?>
<h2>Панель</h2>

<div class="grid">
  <div class="card">Услуг: <b><?= $cntServices ?></b></div>
  <div class="card">Клиентов: <b><?= $cntClients ?></b></div>
  <div class="card">Исполнителей: <b><?= $cntPerf ?></b></div>
  <div class="card">Заказов: <b><?= $cntOrders ?></b></div>
  <div class="card">Отзывов: <b><?= $cntReviews ?></b></div>
</div>

<h2>📨 Рассылка клиентам</h2>
<div style="display:flex; gap:12px; align-items:flex-start; max-width:900px;">
  <textarea id="newsletterText" rows="5" style="flex:1; padding:12px; border-radius:10px; border:1px solid #ccc;"
    placeholder="Текст рассылки всем клиентам..."></textarea>

  <button id="btnNewsletter" style="padding:12px 18px; border-radius:10px; border:none; cursor:pointer;">
    Рассылка
  </button>
</div>

<div id="newsletterResult" style="margin-top:10px;"></div>

<div id="mailResult" style="margin-top:1rem;"></div>
<script>
  document.getElementById('btnNewsletter').addEventListener('click', async () => {
    const text = document.getElementById('newsletterText').value.trim();
    const out = document.getElementById('newsletterResult');

    if (!text) {
      out.innerHTML = '<span style="color:red;">Введите текст рассылки</span>';
      return;
    }

    out.textContent = 'Отправка...';

    try {
      const res = await fetch('/admin/api_send_newsletter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: text })
      });

      const data = await res.json();

      if (data.success) {
        out.innerHTML = `<span style="color:green;">Готово ✅ Отправлено: ${data.sent}, ошибок: ${data.failed}, всего: ${data.total}</span>`;
        document.getElementById('newsletterText').value = '';
      } else {
        out.innerHTML = `<span style="color:red;">Ошибка: ${data.message}</span>`;
      }
    } catch (e) {
      out.innerHTML = `<span style="color:red;">Ошибка запроса: ${e.message}</span>`;
    }
  });
</script>

<?php require_once __DIR__ . '/layout_bottom.php'; ?>