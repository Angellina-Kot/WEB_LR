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

            // Очистка полей формы
            nameInput.value = '';
            emailInput.value = '';
            phoneInput.value = '';
            commentInput.value = '';
            urgentToggle.checked = false;
            consentCheckbox.checked = false;
            sliderValueElement.textContent = '0'; // Или установите нужное начальное значение

        } else {
            alert(messages.join("\n"));
        }
    });




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

