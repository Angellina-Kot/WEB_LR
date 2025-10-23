//реклама
function showAd() {
    const adBanner = document.getElementById('adBanner');
    const timer = document.getElementById('timer');
    let seconds = 7;

    adBanner.style.display = 'block'; // Показать баннер

    const countdown = setInterval(() => {
        timer.textContent = `Закроется через ${seconds} секунд${seconds > 1 ? 'ы' : ''}`;
        seconds--;

        if (seconds < 0) {
            clearInterval(countdown);
            adBanner.style.display = 'none'; // Скрыть баннер по истечении времени
        }
    }, 1000);
}

// Показать рекламу при загрузке страницы
window.onload = showAd;