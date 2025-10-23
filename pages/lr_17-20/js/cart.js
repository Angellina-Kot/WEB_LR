// Данные об услугах в формате JSON
const servicesData = {
    "services": [
        {
            "id": 1,
            "title": "Работа с информацией",
            "price": 15000,
            "image": "./img/Работа_инф-я.png",
            "features": [
                "Поиск и проверка информации",
                "Составление персонального досье",
                "Работа с репутацией (защита персональных данных)",
                "Информация по номеру телефона"
            ]
        },
        {
            "id": 2,
            "title": "Розыск",
            "price": 15000,
            "image": "./img/Розыск.png",
            "features": [
                "Розыск должника/мошенника",
                "Поиск пропавших людей",
                "Поиск родственников",
                "Поиск имущества"
            ]
        },
        {
            "id": 3,
            "title": "Слежка и наблюдение",
            "price": 15000,
            "image": "./img/Слежка.png",
            "features": [
                "Наружное наблюдение",
                "Контрнаблюдение",
                "Проверка образа жизни ребенка"
            ]
        },
        {
            "id": 4,
            "title": "Бизнес-разведка",
            "price": 15000,
            "image": "./img/Бизнес-разведка.png",
            "features": [
                "Проверка контрагентов",
                "Досье на компанию",
                "Внештатная служба безопасности",
                "Корпоративное расследование"
            ]
        },
        {
            "id": 5,
            "title": "Сопровождение гражданских дел",
            "price": 15000,
            "image": "./img/Сопровождение_дел.png",
            "features": [
                "Оказание юридической помощи",
                "Частное расследование преступлений",
                "Содействие правоохранительным органам"
            ]
        },
        {
            "id": 6,
            "title": "Защита",
            "price": 15000,
            "image": "./img/Защита.png",
            "features": [
                "Защита при шантаже и угрозах",
                "Безопасность семьи и детей",
                "Помощь в подготовке и сопровождение в поездках"
            ]
        }
    ]
};

// Инициализация приложения после загрузки DOM
document.addEventListener('DOMContentLoaded', function () {
    // Получаем элементы DOM
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const cartCount = document.querySelector('.cart-count');
    const cartModal = document.getElementById('cart-modal');
    const cartTrigger = document.querySelector('.cart-trigger');
    const closeCart = document.querySelector('.close-cart');
    const continueBtn = document.querySelector('.btn-continue');
    const checkoutBtn = document.querySelector('.btn-checkout');
    const notification = document.getElementById('notification');

    // Массив для хранения товаров в корзине
    let cart = [];

    // Инициализация кнопок "Добавить в корзину"
    function initializeAddToCartButtons() {
        // Находим все кнопки "Добавить в корзину"
        const addToCartButtons = document.querySelectorAll('.btn-more');

        // Добавляем обработчик события для каждой кнопки
        addToCartButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                // ID услуги соответствует индексу + 1 (так как услуги начинаются с ID 1)
                const serviceId = parseInt(this.getAttribute('data-id'));
                addToCart(serviceId);
            });
        });
    }

    // Функция добавления услуги в корзину
    function addToCart(serviceId) {
        // Находим услугу по ID
        const service = servicesData.services.find(s => s.id === serviceId);

        if (service) {
            // Проверяем, есть ли уже такая услуга в корзине
            const existingItem = cart.find(item => item.id === serviceId);

            if (existingItem) {
                // Если услуга уже в корзине, увеличиваем количество
                existingItem.quantity += 1;
            } else {
                // Если услуги нет в корзине, добавляем новую запись
                cart.push({
                    id: service.id,
                    title: service.title,
                    price: service.price,
                    quantity: 1
                });
            }

            // Обновляем отображение корзины
            updateCart();
            // Показываем уведомление
            showNotification();
        }
    }

    // Функция удаления услуги из корзины
    function removeFromCart(serviceId) {
        // Фильтруем массив корзины, удаляя элемент с указанным ID
        cart = cart.filter(item => item.id !== serviceId);
        // Обновляем отображение корзины
        updateCart();
    }

    // Функция обновления отображения корзины
    function updateCart() {
        // Очищаем контейнер с товарами
        cartItems.innerHTML = '';

        // Проверяем, пуста ли корзина
        if (cart.length === 0) {
            // Если корзина пуста, показываем сообщение
            cartItems.innerHTML = '<div class="empty-cart">Корзина пуста</div>';
        } else {
            // Если в корзине есть товары, отображаем их
            cart.forEach(item => {
                // Создаем элемент для товара в корзине
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                cartItemElement.innerHTML = `
                    <div class="item-info">
                        <h3 class="item-name">${item.title}</h3>
                        <div class="item-price">${item.price.toLocaleString()} у.е. x ${item.quantity}</div>
                    </div>
                    <button class="item-remove" data-id="${item.id}">
                       &times;  <!-- Или используйте иконку крестика -->
                    </button>
                `;
                // Добавляем товар в контейнер
                cartItems.appendChild(cartItemElement);
            });

            // Добавляем обработчики событий для кнопок удаления
            document.querySelectorAll('.item-remove').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = parseInt(this.getAttribute('data-id'));
                    removeFromCart(serviceId);
                });
            });
        }

        // Рассчитываем общую сумму корзины
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        // Обновляем отображение общей суммы
        cartTotal.textContent = `Итого: ${total.toLocaleString()} у.е.`;
        // Рассчитываем общее количество товаров в корзине
        const totalCount = cart.reduce((count, item) => count + item.quantity, 0);
        // Обновляем счетчик в кнопке корзины
        cartCount.textContent = totalCount;
    }

    // Функция показа уведомления о добавлении в корзину
    function showNotification() {
        // Добавляем класс для показа уведомления
        notification.classList.add('active');
        // Через 3 секунды скрываем уведомление
        setTimeout(() => {
            notification.classList.remove('active');
        }, 3000);
    }

    // Функция открытия модального окна корзины
    function openCartModal() {
        cartModal.classList.add('active');
    }

    // Функция закрытия модального окна корзины
    function closeCartModal() {
        cartModal.classList.remove('active');
    }

    // Обработчик события для кнопки открытия корзины
    cartTrigger.addEventListener('click', openCartModal);

    // Обработчики событий для закрытия корзины
    closeCart.addEventListener('click', closeCartModal);
    continueBtn.addEventListener('click', closeCartModal);

    // Закрытие корзины при клике вне модального окна
    cartModal.addEventListener('click', function (e) {
        if (e.target === cartModal) {
            closeCartModal();
        }
    });

    // Обработчик события для кнопки оформления заказа
    checkoutBtn.addEventListener('click', function () {
        // Проверяем, не пуста ли корзина
        if (cart.length === 0) {
            alert('Корзина пуста!');
            return;
        }

        // Рассчитываем общую сумму заказа
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        // Показываем сообщение об успешном оформлении заказа
        alert(`Заказ оформлен! Сумма заказа: ${total.toLocaleString()} у.е.\nС вами свяжется наш менеджер в ближайшее время.`);

        // Очищаем корзину
        cart = [];
        // Обновляем отображение корзины
        updateCart();
        // Закрываем модальное окно корзины
        closeCartModal();
    });

    // Инициализация приложения
    initializeAddToCartButtons();
    updateCart();
});