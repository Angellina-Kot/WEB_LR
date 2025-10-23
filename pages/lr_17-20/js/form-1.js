document.getElementById('return-to-form').addEventListener('click', function () {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('success-message').style.display = 'none';
});

// document.getElementById('open-form-button').addEventListener('click', function () {
//     document.getElementById('popup').style.display = 'flex';    
// });
function openPopup() {
    document.getElementById('popup').style.display = 'flex';
    document.getElementById('overlay').style.display = 'block';
}

// Обработчики событий для открытия попапа
const openButtons = document.querySelectorAll('.open-form-button');
openButtons.forEach(button => {
    button.addEventListener('click', openPopup);
});


document.getElementById('return-to-site').addEventListener('click', function () {
    document.getElementById('success-message').style.display = 'none';
    window.scrollTo({ top: 0, behavior: 'smooth' }); // Возвращаемся плавно в начало страницы
});

// document.getElementById('login-form').addEventListener('submit', function (event) {
//     event.preventDefault(); // Предотвратить стандартную отправку формы
    //валидация полей формы
    document.getElementById('submit').addEventListener('click', function (e) {
        e.preventDefault(); // Отменяем стандартное поведение (отправку формы)

        const nameInput = document.getElementById('name-1');
        const emailInput = document.getElementById('email-1');
        const phoneInput = document.getElementById('phone-1');
        const commentInput = document.getElementById('comment-1');
        const urgentToggle = document.getElementById('urgent-toggle-1');
        const consentCheckbox = document.getElementById('consent-1');
        const sliderValueElement = document.getElementById('slider-value');


        let valid = true;
        let messages = [];

        // Проверка имени
        if (nameInput.value.trim() === '') {
            valid = false;
            messages.push("Введите ваше имя.");
        }

        // Проверка email
        const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/i;
        if (emailInput.value.trim() === '') {
            valid = false;
            messages.push("Введите email.");
        } else if (!emailPattern.test(emailInput.value.trim())) {
            valid = false;
            messages.push("Введите корректный email.");
        }

        // Проверка телефона
        if (phoneInput.value.trim() === '') {
            valid = false;
            messages.push("Введите номер телефона.");
        }

        if (valid) {
            // Извлечение данных
            const name = nameInput.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();
            const urgentStatus = urgentToggle.checked;
            const comment = commentInput.value.trim();
            // Извлекаем текст
            const sliderValueText = sliderValueElement.textContent;

            // Формирование сообщения
            let message1 = "Имя: " + name + "\n";
            message1 += "Email: " + email + "\n";
            message1 += "Телефон: " + phone + "\n";
            message1 += "Срочная задача: " + (urgentStatus ? "Да" : "Нет") + "\n";
            message1 += "Комментарий: " + comment + "\n";
            message1 += "Согласие: " + (consentCheckbox.checked ? "Да" : "Нет") + "\n";
            message1 += "Важность: " + sliderValueText;
            // Вывод результата
            alert(message1);
        } else {
            alert(messages.join("\n"));
        }
    });
//     this.reset(); // Очистить форму
// });




//маска на ввод номера телефона
document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.querySelectorAll('.popup__input')[2]; // поле "Мой номер"

    phoneInput.addEventListener("input", function (e) {
        let input = phoneInput.value.replace(/\D/g, '').substring(0, 11); // Убираем всё, кроме цифр, максимум 11 цифр
        let formatted = '+7';

        if (input.length > 1) {
            formatted += ' (' + input.substring(1, 4);
        }
        if (input.length >= 4) {
            formatted += ') ' + input.substring(4, 7);
        }
        if (input.length >= 7) {
            formatted += '-' + input.substring(7, 9);
        }
        if (input.length >= 9) {
            formatted += '-' + input.substring(9, 11);
        }

        phoneInput.value = formatted;
    });

    phoneInput.addEventListener("focus", function () {
        if (phoneInput.value === '') {
            phoneInput.value = '+7 ';
        }
    });

    phoneInput.addEventListener("blur", function () {
        if (phoneInput.value === '+7 ') {
            phoneInput.value = '';
        }
    });
});

// let slider = document.getElementById('slider');
// let thumb = slider.querySelector('.thumb');
// let valueBox = document.getElementById('slider-value');
// let shiftX = 0;

// function updateValue(newLeft) {
//     let rightEdge = slider.offsetWidth - thumb.offsetWidth;
//     let percent = Math.round((newLeft / rightEdge) * 100);
//     valueBox.textContent = percent + '%';
//     thumb.dataset.value = percent; // сохраняем значение в dataset (можно потом достать)
// }


// document.getElementById('submit').addEventListener('click', function () {
//     const toggle = document.getElementById('urgent-toggle');
//     const urgentStatus = toggle.checked;

//     // Выводим статус на экран
//     document.getElementById('output').textContent = urgentStatus ? "Это срочная задача" : "Это не срочная задача";

//     // Создаем объект для JSON
//     const statusData = {
//         urgent: urgentStatus
//     };

//     // Преобразуем объект в JSON
//     const jsonData = JSON.stringify(statusData);
//     console.log("JSON данные:", jsonData);

//     // Сохраняем данные в cookies
//     document.cookie = `urgentStatus=${urgentStatus}; path=/; max-age=3600`; // cookie будет доступно 1 час
// });

// document.getElementById('save-btn').addEventListener('click', function () {
//     const consentCheckbox = document.getElementById('consent');
//     const consentStatus = consentCheckbox.checked; // Получаем состояние чекбокса

//     // Выводим статус на экран
//     const outputText = consentStatus ? "Согласие дано" : "Согласие не дано";
//     document.getElementById('output').textContent = outputText;

//     // Создаем объект для JSON
//     const consentData = {
//         consent: consentStatus
//     };

//     // Преобразуем объект в JSON
//     const jsonData = JSON.stringify(consentData);
//     console.log("JSON данные:", jsonData);

//     // Сохраняем данные в cookies
//     document.cookie = `consentStatus=${consentStatus}; path=/; max-age=3600`; // cookie будет доступно 1 час
// });