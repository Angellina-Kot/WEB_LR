document.querySelector('.about__img-link-1').addEventListener('click', function (event) {
    event.preventDefault(); // Отменяем стандартное поведение ссылки

    window.scrollTo({
        top: 0,            // Прокручиваемся к началу страницы
        behavior: 'smooth' // Плавная прокрутка
    });
});