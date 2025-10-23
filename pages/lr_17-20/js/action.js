// таймер для акции
let deadline = new Date("December 3, 2025"); // Дата окончания

function updateCountdown() {
    const now = new Date().getTime();
    const timeLeft = deadline - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s`;
}

setInterval(updateCountdown, 1000); // Обновляем каждую секунду
updateCountdown(); // Первая инициализация