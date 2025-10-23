
// рабочий код

// document.getElementById('connection-form').addEventListener('submit', function (event) {
//     event.preventDefault(); // Предотвратить стандартную отправку формы

//     const name = document.getElementById('name-2').value;
//     const phone = document.getElementById('phone-2').value;
//     const email = document.getElementById('email-2').value;
//     const password = document.getElementById('password-2').value;
//     const confirmPassword = document.getElementById('confirm-password-2').value;
//     const consentCheckbox = document.getElementById('consent-2');
//     const consent = consentCheckbox.checked ? "Да" : "Нет";

//     // Проверка на согласие
//     // if (consent = "Нет") {
//     //     alert("Вы должны согласиться на обработку данных!");
//     //     return; // Прерываем выполнение
//     // }

//     // Проверка на совпадение паролей
//     if (password !== confirmPassword) {
//         alert("Пароли не совпадают!");
//         return; // Прерываем выполнение
//     }

//     alert(`Данные формы:\n\nИмя: ${name}\nТелефон: ${phone}\nEmail: ${email}\nПароль: ${password}\nСогласие на обработку: ${consent}`);

//     this.reset(); // Очистить форму
// });

// рабочий код №1

document.getElementById('connection-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Предотвратить стандартную отправку формы

    const name = document.getElementById('name-2').value;
    const phone = document.getElementById('phone-2').value;
    const email = document.getElementById('email-2').value;
    const password = document.getElementById('password-2').value;
    const confirmPassword = document.getElementById('confirm-password-2').value;
    const consentCheckbox = document.getElementById('consent-2');


    // Проверка на согласие
    if (!consentCheckbox.checked) {
        alert("Вы должны согласиться на обработку данных!");
        return; // Прерываем выполнение
    }

    // Проверка на совпадение паролей
    if (password !== confirmPassword) {
        alert("Пароли не совпадают!");
        return; // Прерываем выполнение
    }

    const consent = consentCheckbox.checked ? "Да" : "Нет";

    // Создание объекта данных
    const formData = {
        name: name,
        phone: phone,
        email: email,
        password: password,
        consent: consent
    };

    // Сохранение данных в JSON
    const jsonData = JSON.stringify(formData);

    // Запись в cookies
    document.cookie = `formData=${encodeURIComponent(jsonData)}; path=/; max-age=3600`; // 1 час

    // Чтение из cookies
    const cookies = document.cookie.split('; ');
    let cookieData = null;
    for (let cookie of cookies) {
        if (cookie.startsWith('formData=')) {
            cookieData = decodeURIComponent(cookie.split('=')[1]);
            break;
        }
    }

    // Сохранение в localStorage
    if (cookieData) {
        localStorage.setItem('formData', cookieData);
    }

    alert(`Данные формы сохранены:\n${cookieData}`);

    this.reset(); // Очистить форму
});



// document.getElementById('connection-form').addEventListener('submit', function (event) {
//     event.preventDefault(); // Предотвратить стандартную отправку формы

//     // Добавим проверку существования элементов
//     const name = document.getElementById('name-2');
//     const phone = document.getElementById('phone-2');
//     const email = document.getElementById('email-2');
//     const password = document.getElementById('password-2');
//     const confirmPassword = document.getElementById('confirm-password-2');
//     const consentCheckbox = document.getElementById('consent-2');

//     // Проверка, что все элементы найдены
//     if (!name || !phone || !email || !password || !confirmPassword || !consentCheckbox) {
//         console.error('Один или несколько элементов формы не найдены!');
//         alert('Ошибка загрузки формы. Пожалуйста, обновите страницу.');
//         return;
//     }

//     // Получаем значения
//     const nameValue = name.value.trim();
//     const phoneValue = phone.value.trim();
//     const emailValue = email.value.trim();
//     const passwordValue = password.value;
//     const confirmPasswordValue = confirmPassword.value;

//     // ДЕБАГ: Выведем в консоль значения для проверки
//     console.log('Значения формы:', {
//         name: nameValue,
//         phone: phoneValue,
//         email: emailValue,
//         password: passwordValue,
//         confirmPassword: confirmPasswordValue,
//         consent: consentCheckbox.checked
//     });

//     // Проверка на согласие
//     if (!consentCheckbox.checked) {
//         alert("Вы должны согласиться на обработку данных!");
//         consentCheckbox.focus(); // Фокусируемся на чекбоксе
//         return;
//     }

//     // Проверка на заполнение обязательных полей
//     if (!nameValue || !phoneValue || !emailValue || !passwordValue || !confirmPasswordValue) {
//         alert("Пожалуйста, заполните все обязательные поля!");
//         return;
//     }

//     // Проверка на совпадение паролей
//     if (passwordValue !== confirmPasswordValue) {
//         alert("Пароли не совпадают!");
//         password.value = '';
//         confirmPassword.value = '';
//         password.focus();
//         return;
//     }

//     // Проверка сложности пароля (опционально)
//     if (passwordValue.length < 6) {
//         alert("Пароль должен содержать минимум 6 символов!");
//         password.focus();
//         return;
//     }

//     const consent = consentCheckbox.checked ? "Да" : "Нет";

//     // Создание объекта данных
//     const formData = {
//         name: nameValue,
//         phone: phoneValue,
//         email: emailValue,
//         password: passwordValue,
//         consent: consent,
//         timestamp: new Date().toISOString()
//     };

//     try {
//         // Сохранение данных в JSON
//         const jsonData = JSON.stringify(formData);

//         // Запись в cookies
//         document.cookie = `formData=${encodeURIComponent(jsonData)}; path=/; max-age=3600`;

//         // Сохранение в localStorage
//         localStorage.setItem('formData', jsonData);

//         // Проверяем сохранение
//         const savedData = localStorage.getItem('formData');

//         if (savedData) {
//             alert(`Данные успешно сохранены!\n\nИмя: ${nameValue}\nТелефон: ${phoneValue}\nEmail: ${emailValue}`);
//         } else {
//             alert('Произошла ошибка при сохранении данных.');
//         }

//         this.reset(); // Очистить форму

//     } catch (error) {
//         console.error('Ошибка при сохранении данных:', error);
//         alert('Произошла ошибка при сохранении данных.');
//     }});



document.getElementById('login-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Предотвратить стандартную отправку формы

    const email = document.getElementById('email-3').value;
    const password = document.getElementById('password-3').value;

    // Здесь можно добавить проверку правильности email и пароля (например, через API)
    // Для примера просто проверим, что оба поля заполнены
    // if (!email || !password) {
    //     alert("Пожалуйста, заполните все поля!");
    //     return; // Прерываем выполнение
    // }

    alert(`Данные авторизации:\n\nEmail: ${email}\nПароль: ${password}`);

    this.reset(); // Очистить форму
});