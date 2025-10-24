//слайдер
// $('.prev-slide').on('click', function () {
//     $('.services__inner').slick('slickPrev');
// });

// $('.next-slide').on('click', function () {
//     $('.services__inner').slick('slickNext');
// });



$(".services__inner").slick({
    dots: 0,
    autoplay: 0,
    arrows: false,
    autoplaySpeed: 3e3,
    slidesToShow: 4,
    slidesToScroll: 1,
    touchThreshold: 10, pauseOnFocus: !0,
    pauseOnHover: !0,
    responsive: [
        {
            breakpoint: 1770,
            settings: { slidesToShow: 3 }
        },
        {
            breakpoint: 1350,
            settings: { slidesToShow: 2 }
        },
        {
            breakpoint: 900,

            settings: { slidesToShow: 2 }
        },
        { breakpoint: 700, settings: { slidesToShow: 1 } }]

});

// Затем вешаем обработчики на кастомные стрелки
$('.prev-slide').on('click', function () {
    $('.services__inner').slick('slickPrev');
});

$('.next-slide').on('click', function () {
    $('.services__inner').slick('slickNext');
});



document.getElementById('return-to-site').addEventListener('click', function () {
    document.getElementById('success-message').style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' }); // Возвращаемся плавно в начало страницы
});