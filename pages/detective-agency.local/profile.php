<!-- <!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adrasteia — Мой профиль</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
      --primary-dark: #0a192f;
      --secondary-dark: #112240;
      --accent-blue: #64ffda;
      --accent-blue-light: #8892b0;
      --accent-blue-dark: #0d3b66;
      --light-gray: #ccd6f6;
      --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      --success: #00b894;
      --warning: #fdcb6e;
      --danger: #e17055;
    }
    * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { margin:0; background: var(--primary-dark); color: var(--light-gray); }
    header{
      position: sticky; top:0; z-index:1000;
      background: rgba(10,25,47,.95); backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--accent-blue-dark);
      padding: 1rem 1.5rem; display:flex; justify-content:space-between; align-items:center;
    }
    a { color: var(--accent-blue); text-decoration:none; }
    .wrap{ max-width: 1000px; margin: 0 auto; padding: 2rem 1rem; }
    .card{
      background: rgba(17,34,64,.7);
      border: 1px solid rgba(100,255,218,.15);
      border-radius: 20px;
      padding: 1.8rem;
    }
    .grid{ display:grid; gap: 1.2rem; }
    .two{ display:grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 700px){ .two{ grid-template-columns:1fr; } }

    .form-group{ margin-bottom: 1rem; }
    label{ display:block; margin-bottom:.4rem; color: var(--accent-blue-light); font-weight: 500;}
    input, textarea{
      width:100%; padding:.8rem 1rem; border-radius: 10px;
      border: 1px solid var(--accent-blue-dark);
      background: rgba(255,255,255,.05); color: var(--light-gray);
      outline:none;
    }
    textarea{ min-height: 70px; resize: vertical; }

    .btns{ display:flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem; }
    .btn{
      border:none; cursor:pointer; border-radius: 12px; padding: .9rem 1.2rem;
      font-weight: 700; transition: var(--transition);
      display:flex; align-items:center; gap: .6rem;
    }
    .btn-primary{
      background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
      color: var(--primary-dark);
    }
    .btn-secondary{
      background: transparent; color: var(--light-gray);
      border: 1px solid var(--accent-blue-light);
    }
    .btn:hover{ transform: translateY(-2px); }

    .order{
      background: rgba(10,25,47,.5);
      border-radius: 16px;
      padding: 1rem;
      border-left: 3px solid var(--accent-blue);
    }
    .muted{ color: var(--accent-blue-light); }
    .toprow{ display:flex; justify-content:space-between; gap: 1rem; flex-wrap:wrap; }
    .sum{ color: var(--accent-blue); font-weight: 800; }

    .note{
      position: fixed; top: 90px; right: 20px; z-index: 2000;
      max-width: 360px; padding: 14px 16px; border-radius: 12px;
      transform: translateX(150%); transition: transform .35s;
      box-shadow: 0 10px 25px rgba(0,0,0,.3);
      display:flex; gap:10px; align-items:center; font-weight:600;
    }
    .note.show{ transform: translateX(0); }
    .note.success{ background: linear-gradient(45deg, var(--success), #00cec9); color:#fff; }
    .note.error{ background: linear-gradient(45deg, var(--danger), #ff7675); color:#fff; }
    .note.info{ background: linear-gradient(45deg, var(--accent-blue), #4dabf7); color: var(--primary-dark); }
  </style>
</head>
<body>
<header>
  <div style="display:flex; align-items:center; gap: 12px;">
    <i class="fas fa-user-secret" style="color:var(--accent-blue); font-size: 1.6rem;"></i>
    <strong style="letter-spacing:1px;">ADRASTEIA</strong>
  </div>
  <div style="display:flex; gap: 1rem; align-items:center;">
    <a href="/" class="muted"><i class="fas fa-arrow-left"></i> На главную</a>
    <button class="btn btn-secondary" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Выйти</button>
  </div>
</header>

<div class="wrap grid">
  <div class="card">
    <h2 style="margin-top:0; color: var(--accent-blue);">Мой профиль</h2>
    <p class="muted" id="hello">Загрузка...</p>

    <form id="profileForm">
      <div class="two">
        <div class="form-group">
          <label>Имя *</label>
          <input type="text" id="profileName" required>
        </div>
        <div class="form-group">
          <label>Фамилия *</label>
          <input type="text" id="profileLastName" required>
        </div>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" id="profileEmail" disabled>
      </div>

      <div class="two">
        <div class="form-group">
          <label>Телефон</label>
          <input type="tel" id="profilePhone" placeholder="+7 ...">
        </div>
        <div class="form-group">
          <label>Адрес</label>
          <input type="text" id="profileAddress" placeholder="Город, улица...">
        </div>
      </div>

      <div class="btns">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
        <button type="button" class="btn btn-secondary" id="refreshOrdersBtn"><i class="fas fa-sync"></i> Обновить заказы</button>
      </div>
    </form>
  </div>

  <div class="card">
    <h3 style="margin-top:0; color: var(--accent-blue);">Мои заказы</h3>
    <div id="myOrders" class="grid">
      <div class="muted">Загрузка...</div>
    </div>
  </div>
</div>

<div id="note" class="note info"><i class="fas fa-info-circle"></i><span id="noteText"></span></div>

<script>
  const note = document.getElementById('note');
  const noteText = document.getElementById('noteText');
  function notify(text, type='info'){
    note.className = 'note ' + type;
    noteText.textContent = text;
    note.classList.add('show');
    setTimeout(()=>note.classList.remove('show'), 3200);
  }

  const els = {
    hello: document.getElementById('hello'),
    form: document.getElementById('profileForm'),
    name: document.getElementById('profileName'),
    lastName: document.getElementById('profileLastName'),
    email: document.getElementById('profileEmail'),
    phone: document.getElementById('profilePhone'),
    address: document.getElementById('profileAddress'),
    orders: document.getElementById('myOrders'),
    logoutBtn: document.getElementById('logoutBtn'),
    refreshOrdersBtn: document.getElementById('refreshOrdersBtn')
  };

  async function authMe(){
    const r = await fetch('/api/auth_me.php', { credentials: 'include' });
    const data = await r.json().catch(()=>null);
    if (!data || !data.success || !data.user){
      // не авторизован — отправляем на главную
      window.location.href = '/';
      return null;
    }
    return data.user;
  }

  async function loadProfile(){
    const r = await fetch('/api/profile', { credentials:'include' });
    const data = await r.json().catch(()=>null);
    if (!data || !data.success){
      notify(data?.message || 'Не удалось загрузить профиль', 'error');
      return;
    }
    const p = data.profile;
    els.name.value = p.name || '';
    els.lastName.value = p.lastName || '';
    els.email.value = p.email || '';
    els.phone.value = p.phone || '';
    els.address.value = p.address || '';
    els.hello.textContent = `Здравствуйте, ${p.name || ''}!`;
  }

  async function loadOrders(){
    const r = await fetch('/api/orders/my', { credentials:'include' });
    const data = await r.json().catch(()=>null);
    if (!data || !data.success){
      els.orders.innerHTML = '<div class="muted">Не удалось загрузить заказы</div>';
      return;
    }
    if (!data.orders.length){
      els.orders.innerHTML = '<div class="muted">Заказов пока нет</div>';
      return;
    }
    els.orders.innerHTML = data.orders.map(o => `
      <div class="order">
        <div class="toprow">
          <div><strong>#${o.id}</strong> — ${o.status}</div>
          <div class="sum">${Number(o.total).toLocaleString()} ₽</div>
        </div>
        <div class="muted" style="margin-top:.35rem;">
          Дата: ${o.date || '-'}
          ${o.address ? ' • Адрес: ' + o.address : ''}
        </div>
        ${o.comment ? `<div class="muted" style="margin-top:.35rem;">Комментарий: ${o.comment}</div>` : ''}
      </div>
    `).join('');
  }

  els.form.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const payload = {
      name: els.name.value.trim(),
      lastName: els.lastName.value.trim(),
      phone: els.phone.value.trim(),
      address: els.address.value.trim()
    };

    const r = await fetch('/api/profile/update', {
      method:'POST',
      credentials:'include',
      headers:{ 'Content-Type':'application/json', 'Accept':'application/json' },
      body: JSON.stringify(payload)
    });

    const data = await r.json().catch(()=>null);
    if (!data || !data.success){
      notify(data?.message || 'Ошибка сохранения', 'error');
      return;
    }
    notify('Профиль сохранён', 'success');
  });

  els.logoutBtn.addEventListener('click', async ()=>{
    await fetch('/api/auth_logout.php', {
      method:'POST',
      credentials:'include',
      headers:{'Content-Type':'application/json','Accept':'application/json'},
      body: JSON.stringify({})
    }).catch(()=>null);
    window.location.href = '/';
  });

  els.refreshOrdersBtn.addEventListener('click', loadOrders);

  (async ()=>{
    await authMe();
    await loadProfile();
    await loadOrders();
  })();
</script>
</body>
</html> -->




<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adrasteia — Мой профиль</title>
  <link rel="icon" href="/favicon.ico?v=2">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary-dark: #0a192f;
      --secondary-dark: #112240;
      --accent-blue: #64ffda;
      --accent-blue-light: #8892b0;
      --accent-blue-dark: #0d3b66;
      --light-gray: #ccd6f6;
      --transition: all .25s cubic-bezier(.25, .46, .45, .94);
      --success: #00b894;
      --warning: #fdcb6e;
      --danger: #e17055;
      --card: rgba(17, 34, 64, .72);
      --card2: rgba(10, 25, 47, .55);
      --line: rgba(100, 255, 218, .15);
    }

    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      margin: 0;
      background: var(--primary-dark);
      color: var(--light-gray);
    }

    header {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: rgba(10, 25, 47, .95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--accent-blue-dark);
      padding: 1rem 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .brand i {
      color: var(--accent-blue);
      font-size: 1.6rem;
      filter: drop-shadow(0 0 6px rgba(100, 255, 218, .25));
    }

    .brand strong {
      letter-spacing: 1px;
    }

    a {
      color: var(--accent-blue);
      text-decoration: none;
    }

    .muted {
      color: var(--accent-blue-light);
    }

    .wrap {
      max-width: 1100px;
      margin: 0 auto;
      padding: 2rem 1rem;
      display: grid;
      gap: 1.2rem;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--line);
      border-radius: 20px;
      padding: 1.8rem;
      box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
    }

    .grid {
      display: grid;
      gap: 1.1rem;
    }

    .two {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    @media (max-width: 760px) {
      .two {
        grid-template-columns: 1fr;
      }
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: .4rem;
      color: var(--accent-blue-light);
      font-weight: 500;
    }

    input,
    textarea {
      width: 100%;
      padding: .85rem 1rem;
      border-radius: 12px;
      border: 1px solid var(--accent-blue-dark);
      background: rgba(255, 255, 255, .05);
      color: var(--light-gray);
      outline: none;
      transition: var(--transition);
    }

    input:focus,
    textarea:focus {
      border-color: var(--accent-blue);
      box-shadow: 0 0 0 2px rgba(100, 255, 218, .12);
    }

    textarea {
      min-height: 74px;
      resize: vertical;
    }

    .btns {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      margin-top: .6rem;
    }

    .btn {
      border: none;
      cursor: pointer;
      border-radius: 14px;
      padding: .9rem 1.2rem;
      font-weight: 700;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: .6rem;
      user-select: none;
    }

    .btn-primary {
      background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
      color: var(--primary-dark);
      box-shadow: 0 10px 25px rgba(100, 255, 218, .22);
    }

    .btn-secondary {
      background: transparent;
      color: var(--light-gray);
      border: 1px solid rgba(136, 146, 176, .7);
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    /* ===== Orders UI ===== */
    .order {
      background: var(--card2);
      border: 1px solid rgba(100, 255, 218, .10);
      border-radius: 18px;
      overflow: hidden;
    }

    .order-head {
      padding: 1rem 1.1rem;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 1rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .order-head:hover {
      background: rgba(10, 25, 47, .65);
    }

    .order-left {
      display: flex;
      gap: .9rem;
      align-items: flex-start;
    }

    .order-badge {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(100, 255, 218, .12);
      border: 1px solid rgba(100, 255, 218, .18);
      color: var(--accent-blue);
      flex: 0 0 auto;
    }

    .order-title {
      display: flex;
      align-items: center;
      gap: .6rem;
      flex-wrap: wrap;
    }

    .order-title strong {
      font-size: 1.05rem;
    }

    .status {
      padding: .22rem .6rem;
      border-radius: 999px;
      font-size: .85rem;
      font-weight: 800;
      border: 1px solid rgba(255, 255, 255, .12);
    }

    .status.new {
      background: rgba(77, 171, 247, .14);
      color: #a5d8ff;
      border-color: rgba(77, 171, 247, .25);
    }

    .status.progress {
      background: rgba(253, 203, 110, .14);
      color: #ffeaa7;
      border-color: rgba(253, 203, 110, .25);
    }

    .status.done {
      background: rgba(0, 184, 148, .14);
      color: #55efc4;
      border-color: rgba(0, 184, 148, .25);
    }

    .status.cancel {
      background: rgba(225, 112, 85, .14);
      color: #ff7675;
      border-color: rgba(225, 112, 85, .25);
    }

    .order-meta {
      margin-top: .35rem;
      display: flex;
      gap: .8rem;
      flex-wrap: wrap;
    }

    .chip {
      display: inline-flex;
      align-items: center;
      gap: .45rem;
      padding: .25rem .55rem;
      border-radius: 999px;
      background: rgba(17, 34, 64, .65);
      border: 1px solid rgba(100, 255, 218, .10);
      color: var(--accent-blue-light);
      font-size: .85rem;
      font-weight: 600;
    }

    .order-right {
      text-align: right;
      min-width: 160px;
    }

    .sum {
      color: var(--accent-blue);
      font-weight: 900;
      font-size: 1.15rem;
    }

    .toggle {
      margin-top: .25rem;
      color: var(--accent-blue-light);
      font-weight: 700;
      font-size: .9rem;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: .45rem;
    }

    .order-body {
      display: none;
      padding: 0 1.1rem 1.1rem;
      border-top: 1px solid rgba(100, 255, 218, .10);
    }

    .order.open .order-body {
      display: block;
    }

    .items {
      margin-top: 1rem;
      display: grid;
      gap: .65rem;
    }

    .item {
      background: rgba(17, 34, 64, .55);
      border: 1px solid rgba(100, 255, 218, .10);
      border-radius: 14px;
      padding: .8rem .9rem;
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .item .name {
      font-weight: 800;
    }

    .item .line {
      color: var(--accent-blue-light);
      font-weight: 600;
      margin-top: .2rem;
    }

    .item .right {
      text-align: right;
    }

    .item .money {
      color: var(--accent-blue);
      font-weight: 900;
    }

    .order-note {
      margin-top: .9rem;
      padding: .85rem .95rem;
      border-radius: 14px;
      border: 1px dashed rgba(100, 255, 218, .22);
      background: rgba(10, 25, 47, .45);
      color: var(--accent-blue-light);
      line-height: 1.6;
    }

    /* Notifications */
    .note {
      position: fixed;
      top: 90px;
      right: 20px;
      z-index: 2000;
      max-width: 360px;
      padding: 14px 16px;
      border-radius: 12px;
      transform: translateX(150%);
      transition: transform .35s;
      box-shadow: 0 10px 25px rgba(0, 0, 0, .3);
      display: flex;
      gap: 10px;
      align-items: center;
      font-weight: 600;
    }

    .note.show {
      transform: translateX(0);
    }

    .note.success {
      background: linear-gradient(45deg, var(--success), #00cec9);
      color: #fff;
    }

    .note.error {
      background: linear-gradient(45deg, var(--danger), #ff7675);
      color: #fff;
    }

    .note.info {
      background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
      color: var(--primary-dark);
    }
  </style>
</head>

<body>
  <header>
    <div class="brand">
      <i class="fas fa-user-secret"></i>
      <strong>ADRASTEIA</strong>
    </div>

    <div style="display:flex; gap: 1rem; align-items:center;">
      <a href="/" class="muted"><i class="fas fa-arrow-left"></i> На главную</a>
      <button class="btn btn-secondary" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Выйти</button>
    </div>
  </header>

  <div class="wrap">
    <div class="card">
      <h2 style="margin:0 0 .5rem 0; color: var(--accent-blue);">Мой профиль</h2>
      <p class="muted" id="hello" style="margin-top:0;">Загрузка...</p>

      <form id="profileForm">
        <div class="two">
          <div class="form-group">
            <label>Имя *</label>
            <input type="text" id="profileName" required>
          </div>
          <div class="form-group">
            <label>Фамилия *</label>
            <input type="text" id="profileLastName" required>
          </div>
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" id="profileEmail" disabled>
        </div>

        <div class="two">
          <div class="form-group">
            <label>Телефон</label>
            <input type="tel" id="profilePhone" placeholder="+375 (__) ___-__-__">
          </div>
          <div class="form-group">
            <label>Адрес</label>
            <input type="text" id="profileAddress" placeholder="Город, улица...">
          </div>
        </div>

        <div class="btns">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Сохранить</button>
          <button type="button" class="btn btn-secondary" id="refreshOrdersBtn"><i class="fas fa-sync"></i> Обновить
            заказы</button>
        </div>
      </form>
    </div>

    <div class="card">
      <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
        <div>
          <h3 style="margin:0; color: var(--accent-blue);">Мои заказы</h3>
          <div class="muted" id="ordersHint" style="margin-top:.35rem;">Нажмите на заказ, чтобы увидеть позиции</div>
        </div>
        <div class="muted" id="ordersCount"></div>
      </div>

      <div id="myOrders" class="grid" style="margin-top: 1rem;">
        <div class="muted">Загрузка...</div>
      </div>
    </div>
  </div>

  <div id="note" class="note info"><i class="fas fa-info-circle"></i><span id="noteText"></span></div>

  <script>
    const note = document.getElementById('note');
    const noteText = document.getElementById('noteText');
    function notify(text, type = 'info') {
      note.className = 'note ' + type;
      noteText.textContent = text;
      note.classList.add('show');
      setTimeout(() => note.classList.remove('show'), 3200);
    }

    const els = {
      hello: document.getElementById('hello'),
      form: document.getElementById('profileForm'),
      name: document.getElementById('profileName'),
      lastName: document.getElementById('profileLastName'),
      email: document.getElementById('profileEmail'),
      phone: document.getElementById('profilePhone'),
      address: document.getElementById('profileAddress'),
      orders: document.getElementById('myOrders'),
      ordersCount: document.getElementById('ordersCount'),
      logoutBtn: document.getElementById('logoutBtn'),
      refreshOrdersBtn: document.getElementById('refreshOrdersBtn')
    };

    function escapeHtml(s) {
      return String(s ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", "&#039;");
    }

    function statusClass(status) {
      const s = (status || '').toLowerCase();
      if (s.includes('нов') || s.includes('new')) return 'new';
      if (s.includes('вып') || s.includes('done') || s.includes('зав')) return 'done';
      if (s.includes('отм') || s.includes('cancel') || s.includes('rejected')) return 'cancel';
      if (s.includes('в раб') || s.includes('process') || s.includes('выполн')) return 'progress';
      return 'new';
    }

    function formatMoney(v) {
      const n = Number(v || 0);
      return n.toLocaleString('ru-RU') + ' ₽';
    }

    async function authMe() {
      const r = await fetch('/api/auth_me.php', { credentials: 'include' });
      const data = await r.json().catch(() => null);
      if (!data || !data.success || !data.user) {
        window.location.href = '/';
        return null;
      }
      return data.user;
    }

    async function loadProfile() {
      const r = await fetch('/api/profile', { credentials: 'include' });
      const data = await r.json().catch(() => null);
      if (!data || !data.success) {
        notify(data?.message || 'Не удалось загрузить профиль', 'error');
        return;
      }
      const p = data.profile;
      els.name.value = p.name || '';
      els.lastName.value = p.lastName || '';
      els.email.value = p.email || '';
      els.phone.value = p.phone || '';
      els.address.value = p.address || '';
      els.hello.textContent = `Здравствуйте, ${p.name || ''}!`;
    }

    function renderOrders(orders) {
      els.ordersCount.textContent = orders.length ? `Всего: ${orders.length}` : '';

      if (!orders.length) {
        els.orders.innerHTML = '<div class="muted">Заказов пока нет</div>';
        return;
      }

      els.orders.innerHTML = orders.map(o => {
        const items = Array.isArray(o.items) ? o.items : [];
        const itemsCount = items.reduce((acc, it) => acc + Number(it.qty || it.quantity || 0), 0);

        const addr = o.address ? `<span class="chip"><i class="fas fa-map-marker-alt"></i>${escapeHtml(o.address)}</span>` : '';
        const date = o.date ? `<span class="chip"><i class="fas fa-calendar-alt"></i>${escapeHtml(o.date)}</span>` : '';
        const countChip = `<span class="chip"><i class="fas fa-list"></i>${items.length} поз. / ${itemsCount} шт.</span>`;

        const itemsHtml = items.length ? items.map(it => {
          const name = escapeHtml(it.name || '');
          const qty = Number(it.qty ?? it.quantity ?? 0);
          const unit = Number(it.unit ?? it.unitPrice ?? 0);
          const sum = Number(it.sum ?? (unit * qty) ?? 0);

          return `
          <div class="item">
            <div class="left">
              <div class="name">${name}</div>
              <div class="line">${qty} × ${formatMoney(unit)}</div>
            </div>
            <div class="right">
              <div class="money">${formatMoney(sum)}</div>
            </div>
          </div>
        `;
        }).join('') : '<div class="muted" style="margin-top:1rem;">Позиции не найдены</div>';

        const commentHtml = o.comment ? `
        <div class="order-note">
          <strong style="color: var(--accent-blue);">Комментарий:</strong>
          <div style="margin-top:.35rem;">${escapeHtml(o.comment)}</div>
        </div>
      ` : '';

        return `
        <div class="order" data-order>
          <div class="order-head" data-toggle>
            <div class="order-left">
              <div class="order-badge"><i class="fas fa-receipt"></i></div>
              <div>
                <div class="order-title">
                  <strong>#${escapeHtml(o.id)}</strong>
                  <span class="status ${statusClass(o.status)}">${escapeHtml(o.status || 'новый')}</span>
                </div>
                <div class="order-meta">
                  ${date}
                  ${addr}
                  ${countChip}
                </div>
              </div>
            </div>

            <div class="order-right">
              <div class="sum">${formatMoney(o.total)}</div>
              <div class="toggle"><span>Позиции</span><i class="fas fa-chevron-down"></i></div>
            </div>
          </div>

          <div class="order-body">
            <div class="items">${itemsHtml}</div>

            <div class="btns" style="margin-top: 1rem;">
              <a class="btn btn-primary"
                href="/api/orders/${encodeURIComponent(o.id)}/receipt"
                target="_blank"
                rel="noopener">
                <i class="fas fa-file-pdf"></i> Счёт на оплату (PDF)
              </a>

            </div>

            ${commentHtml}
          </div>
        </div>
      `;
      }).join('');

      // toggle behavior (accordion-like)
      document.querySelectorAll('[data-order]').forEach(orderEl => {
        const head = orderEl.querySelector('[data-toggle]');
        head.addEventListener('click', () => {
          const isOpen = orderEl.classList.contains('open');

          // Закрываем остальные (как аккордеон)
          document.querySelectorAll('[data-order].open').forEach(x => {
            if (x !== orderEl) x.classList.remove('open');
          });

          orderEl.classList.toggle('open', !isOpen);

          // меняем стрелку
          document.querySelectorAll('[data-order] .toggle i').forEach(i => i.style.transform = 'rotate(0deg)');
          const icon = orderEl.querySelector('.toggle i');
          if (icon) icon.style.transform = orderEl.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
      });
    }

    async function loadOrders() {
      const r = await fetch('/api/orders/my', { credentials: 'include' });
      const data = await r.json().catch(() => null);

      if (!data || !data.success) {
        els.orders.innerHTML = '<div class="muted">Не удалось загрузить заказы</div>';
        return;
      }
      renderOrders(Array.isArray(data.orders) ? data.orders : []);
    }

    els.form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const payload = {
        name: els.name.value.trim(),
        lastName: els.lastName.value.trim(),
        phone: els.phone.value.trim(),
        address: els.address.value.trim()
      };

      const r = await fetch('/api/profile/update', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify(payload)
      });

      const data = await r.json().catch(() => null);
      if (!data || !data.success) {
        notify(data?.message || 'Ошибка сохранения', 'error');
        return;
      }
      notify('Профиль сохранён', 'success');
    });

    els.logoutBtn.addEventListener('click', async () => {
      await fetch('/api/auth_logout.php', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({})
      }).catch(() => null);
      window.location.href = '/';
    });

    els.refreshOrdersBtn.addEventListener('click', loadOrders);

    (async () => {
      await authMe();
      await loadProfile();
      await loadOrders();
    })();
  </script>
</body>

</html>