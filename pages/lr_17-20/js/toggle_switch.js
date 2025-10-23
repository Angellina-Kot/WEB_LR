const toggle = document.getElementById('urgent-toggle');
const valueBox = document.getElementById('toggle-value');

toggle.addEventListener('change', () => {
    let val = toggle.checked ? 1 : 0;
    valueBox.textContent = val;

    // Пример записи в localStorage (можно заменить на fetch -> сервер -> файл)
    localStorage.setItem("urgentTask", val);
});