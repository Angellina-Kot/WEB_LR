//исчезновение текста по наведению на него
$(document).ready(function () {
    $('.mission__title__down').css('opacity', 0).animate({ opacity: 1 }, 1000); // Появление

    $('.mission__title__down').hover(
        function () {
            $(this).animate({ opacity: 0 }, 500); // Исчезновение
        },
        function () {
            $(this).animate({ opacity: 1 }, 500); // Появление обратно
        }
    );
});