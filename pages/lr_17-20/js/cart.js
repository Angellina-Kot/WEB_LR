
// // Глобальная переменная для хранения данных об услугах
// let servicesData = {};

// // Функция загрузки данных из JSON файла
// async function loadServicesData() {
//     try {
//         const response = await fetch('./services.json');
//         if (!response.ok) {
//             throw new Error('Ошибка загрузки данных об услугах');
//         }
//         servicesData = await response.json();
//         console.log('Данные об услугах загружены:', servicesData);
//         return servicesData;
//     } catch (error) {
//         console.error('Ошибка при загрузке services.json:', error);
//         // Можно добавить fallback данные или показать сообщение об ошибке
//         return { services: [] };
//     }
// }

// // Инициализация приложения после загрузки DOM
// document.addEventListener('DOMContentLoaded', async function () {
//     // Загружаем данные об услугах
//     await loadServicesData();
    
//     // Получаем элементы DOM
//     const cartItems = document.getElementById('cart-items');
//     const cartTotal = document.getElementById('cart-total');
//     const cartCount = document.querySelector('.cart-count');
//     const cartModal = document.getElementById('cart-modal');
//     const cartTrigger = document.querySelector('.cart-trigger');
//     const closeCart = document.querySelector('.close-cart');
//     const continueBtn = document.querySelector('.btn-continue');
//     const checkoutBtn = document.querySelector('.btn-checkout');
//     const notification = document.getElementById('notification');

//     // Массив для хранения товаров в корзине
//     let cart = [];

//     // Инициализация кнопок "Добавить в корзину"
//     function initializeAddToCartButtons() {
//         // Находим все кнопки "Добавить в корзину"
//         const addToCartButtons = document.querySelectorAll('.btn-more');

//         // Добавляем обработчик события для каждой кнопки
//         addToCartButtons.forEach((button, index) => {
//             button.addEventListener('click', function () {
//                 // ID услуги соответствует индексу + 1 (так как услуги начинаются с ID 1)
//                 const serviceId = parseInt(this.getAttribute('data-id'));
//                 addToCart(serviceId);
//             });
//         });
//     }

//     // Функция добавления услуги в корзину
//     function addToCart(serviceId) {
//         // Находим услугу по ID
//         const service = servicesData.services.find(s => s.id === serviceId);

//         if (service) {
//             // Проверяем, есть ли уже такая услуга в корзине
//             const existingItem = cart.find(item => item.id === serviceId);

//             if (existingItem) {
//                 // Если услуга уже в корзине, увеличиваем количество
//                 existingItem.quantity += 1;
//             } else {
//                 // Если услуги нет в корзине, добавляем новую запись
//                 cart.push({
//                     id: service.id,
//                     title: service.title,
//                     price: service.price,
//                     quantity: 1
//                 });
//             }

//             // Обновляем отображение корзины
//             updateCart();
//             // Показываем уведомление
//             showNotification();
//         }
//     }

//     // Функция удаления услуги из корзины
//     function removeFromCart(serviceId) {
//         // Фильтруем массив корзины, удаляя элемент с указанным ID
//         cart = cart.filter(item => item.id !== serviceId);
//         // Обновляем отображение корзины
//         updateCart();
//     }

//     // Функция обновления отображения корзины
//     function updateCart() {
//         // Очищаем контейнер с товарами
//         cartItems.innerHTML = '';

//         // Проверяем, пуста ли корзина
//         if (cart.length === 0) {
//             // Если корзина пуста, показываем сообщение
//             cartItems.innerHTML = '<div class="empty-cart">Корзина пуста</div>';
//         } else {
//             // Если в корзине есть товары, отображаем их
//             cart.forEach(item => {
//                 // Создаем элемент для товара в корзине
//                 const cartItemElement = document.createElement('div');
//                 cartItemElement.className = 'cart-item';
//                 cartItemElement.innerHTML = `
//                     <div class="item-info">
//                         <h3 class="item-name">${item.title}</h3>
//                         <div class="item-price">${item.price.toLocaleString()} у.е. x ${item.quantity}</div>
//                     </div>
//                     <button class="item-remove" data-id="${item.id}">
//                        &times;  <!-- иконка крестика -->
//                     </button>
//                 `;
//                 // Добавляем товар в контейнер
//                 cartItems.appendChild(cartItemElement);
//             });

//             // Добавляем обработчики событий для кнопок удаления
//             document.querySelectorAll('.item-remove').forEach(button => {
//                 button.addEventListener('click', function () {
//                     const serviceId = parseInt(this.getAttribute('data-id'));
//                     removeFromCart(serviceId);
//                 });
//             });
//         }

//         // Рассчитываем общую сумму корзины
//         const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
//         // Обновляем отображение общей суммы
//         cartTotal.textContent = `Итого: ${total.toLocaleString()} у.е.`;
//         // Рассчитываем общее количество товаров в корзине
//         const totalCount = cart.reduce((count, item) => count + item.quantity, 0);
//         // Обновляем счетчик в кнопке корзины
//         cartCount.textContent = totalCount;
//     }

//     // Функция показа уведомления о добавлении в корзину
//     function showNotification() {
//         // Добавляем класс для показа уведомления
//         notification.classList.add('active');
//         // Через 3 секунды скрываем уведомление
//         setTimeout(() => {
//             notification.classList.remove('active');
//         }, 3000);
//     }

//     // Функция открытия модального окна корзины
//     function openCartModal() {
//         cartModal.classList.add('active');
//     }

//     // Функция закрытия модального окна корзины
//     function closeCartModal() {
//         cartModal.classList.remove('active');
//     }

//     // Обработчик события для кнопки открытия корзины
//     cartTrigger.addEventListener('click', openCartModal);

//     // Обработчики событий для закрытия корзины
//     closeCart.addEventListener('click', closeCartModal);
//     continueBtn.addEventListener('click', closeCartModal);

//     // Закрытие корзины при клике вне модального окна
//     cartModal.addEventListener('click', function (e) {
//         if (e.target === cartModal) {
//             closeCartModal();
//         }
//     });

//     // Обработчик события для кнопки оформления заказа
//     checkoutBtn.addEventListener('click', function () {
//         // Проверяем, не пуста ли корзина
//         if (cart.length === 0) {
//             alert('Корзина пуста!');
//             return;
//         }

//         // Рассчитываем общую сумму заказа
//         const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

//         // Показываем сообщение об успешном оформлении заказа
//         alert(`Заказ оформлен! Сумма заказа: ${total.toLocaleString()} у.е.\nС вами свяжется наш менеджер в ближайшее время.`);

//         // Очищаем корзину
//         cart = [];
//         // Обновляем отображение корзины
//         updateCart();
//         // Закрываем модальное окно корзины
//         closeCartModal();
//     });

//     // Инициализация приложения
//     initializeAddToCartButtons();
//     updateCart();
// });



// Глобальная переменная для хранения данных об услугах
let servicesData = {};

// Функция загрузки данных из JSON файла
async function loadServicesData() {
    try {
        const response = await fetch('./services.json');
        if (!response.ok) {
            throw new Error('Ошибка загрузки данных об услугах');
        }
        servicesData = await response.json();
        console.log('Данные об услугах загружены:', servicesData);
        return servicesData;
    } catch (error) {
        console.error('Ошибка при загрузке services.json:', error);
        return { services: [] };
    }
}

// Функции для работы с хранилищем
const storageManager = {
    // Сохранение корзины в localStorage и cookies
    saveCart: function (cart) {
        try {
            const cartData = JSON.stringify(cart);

            // Сохранение в localStorage (основное хранилище)
            localStorage.setItem('shoppingCart', cartData);

            // Сохранение в cookies (резервное хранилище на 7 дней)
            const expires = new Date();
            expires.setDate(expires.getDate() + 7);
            document.cookie = `shoppingCart=${encodeURIComponent(cartData)}; expires=${expires.toUTCString()}; path=/`;

            console.log('Корзина сохранена:', cart);
        } catch (error) {
            console.error('Ошибка при сохранении корзины:', error);
        }
    },

    // Загрузка корзины из хранилища
    loadCart: function () {
        try {
            // Пробуем загрузить из localStorage
            let cartData = localStorage.getItem('shoppingCart');

            // Если в localStorage нет данных, пробуем загрузить из cookies
            if (!cartData) {
                const cookies = document.cookie.split('; ');
                for (let cookie of cookies) {
                    if (cookie.startsWith('shoppingCart=')) {
                        cartData = decodeURIComponent(cookie.split('=')[1]);
                        break;
                    }
                }
            }

            // Парсим данные корзины
            if (cartData) {
                const cart = JSON.parse(cartData);
                console.log('Корзина загружена:', cart);
                return cart;
            }
        } catch (error) {
            console.error('Ошибка при загрузке корзины:', error);
        }

        return []; // Возвращаем пустую корзину при ошибке
    },

    // Очистка корзины из хранилища
    clearCart: function () {
        localStorage.removeItem('shoppingCart');
        document.cookie = 'shoppingCart=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
        console.log('Корзина очищена из хранилища');
    }
};

// Инициализация приложения после загрузки DOM
document.addEventListener('DOMContentLoaded', async function () {
    // Загружаем данные об услугах
    await loadServicesData();

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
    const clearCartBtn = document.getElementById('clear-cart'); // Добавьте эту кнопку в HTML

    // Загружаем корзину из хранилища или создаем пустую
    let cart = storageManager.loadCart();

    // Инициализация кнопок "Добавить в корзину"
    function initializeAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.btn-more');

        addToCartButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                const serviceId = parseInt(this.getAttribute('data-id'));
                addToCart(serviceId);
            });
        });
    }

    // Функция добавления услуги в корзину
    function addToCart(serviceId) {
        const service = servicesData.services.find(s => s.id === serviceId);

        if (service) {
            const existingItem = cart.find(item => item.id === serviceId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: service.id,
                    title: service.title,
                    price: service.price,
                    quantity: 1,
                    addedAt: new Date().toISOString() // Добавляем время добавления
                });
            }

            updateCart();
            showNotification();

            // Сохраняем корзину после добавления товара
            storageManager.saveCart(cart);
        }
    }

    // Функция удаления услуги из корзины
    function removeFromCart(serviceId) {
        cart = cart.filter(item => item.id !== serviceId);
        updateCart();

        // Сохраняем корзину после удаления товара
        storageManager.saveCart(cart);
    }

    // Функция изменения количества товара
    function updateQuantity(serviceId, newQuantity) {
        const item = cart.find(item => item.id === serviceId);
        if (item) {
            if (newQuantity <= 0) {
                removeFromCart(serviceId);
            } else {
                item.quantity = newQuantity;
                updateCart();
                storageManager.saveCart(cart);
            }
        }
    }

    // Функция обновления отображения корзины
    function updateCart() {
        cartItems.innerHTML = '';

        if (cart.length === 0) {
            cartItems.innerHTML = '<div class="empty-cart">Корзина пуста</div>';
        } else {
            cart.forEach(item => {
                const cartItemElement = document.createElement('div');
                cartItemElement.className = 'cart-item';
                cartItemElement.innerHTML = `
                    <div class="item-info">
                        <h3 class="item-name">${item.title}</h3>
                        <div class="item-price">${item.price.toLocaleString()} у.е.</div>
                        <div class="item-quantity-controls">
                            <button class="quantity-btn minus" data-id="${item.id}">-</button>
                            <span class="quantity">${item.quantity}</span>
                            <button class="quantity-btn plus" data-id="${item.id}">+</button>
                        </div>
                    </div>
                    <button class="item-remove" data-id="${item.id}">
                       &times;
                    </button>
                `;
                cartItems.appendChild(cartItemElement);
            });

            // Обработчики для кнопок удаления
            document.querySelectorAll('.item-remove').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = parseInt(this.getAttribute('data-id'));
                    removeFromCart(serviceId);
                });
            });

            // Обработчики для кнопок изменения количества
            document.querySelectorAll('.quantity-btn.minus').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = parseInt(this.getAttribute('data-id'));
                    const item = cart.find(item => item.id === serviceId);
                    if (item) {
                        updateQuantity(serviceId, item.quantity - 1);
                    }
                });
            });

            document.querySelectorAll('.quantity-btn.plus').forEach(button => {
                button.addEventListener('click', function () {
                    const serviceId = parseInt(this.getAttribute('data-id'));
                    const item = cart.find(item => item.id === serviceId);
                    if (item) {
                        updateQuantity(serviceId, item.quantity + 1);
                    }
                });
            });
        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.textContent = `Итого: ${total.toLocaleString()} у.е.`;
        const totalCount = cart.reduce((count, item) => count + item.quantity, 0);
        cartCount.textContent = totalCount;
    }

    // Функция очистки корзины
    function clearCart() {
        if (confirm('Вы уверены, что хотите очистить корзину?')) {
            cart = [];
            updateCart();
            storageManager.clearCart();
            showNotification('Корзина очищена');
        }
    }

    // Функция показа уведомления
    function showNotification(message = 'Товар добавлен в корзину!') {
        notification.textContent = message;
        notification.classList.add('active');

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

    // Обработчики событий
    cartTrigger.addEventListener('click', openCartModal);
    closeCart.addEventListener('click', closeCartModal);
    continueBtn.addEventListener('click', closeCartModal);

    // Обработчик для кнопки очистки корзины (добавьте эту кнопку в HTML)
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', clearCart);
    }

    cartModal.addEventListener('click', function (e) {
        if (e.target === cartModal) {
            closeCartModal();
        }
    });

    checkoutBtn.addEventListener('click', function () {
        if (cart.length === 0) {
            alert('Корзина пуста!');
            return;
        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        // Здесь можно добавить отправку данных на сервер
        console.log('Данные для заказа:', {
            cart: cart,
            total: total,
            orderDate: new Date().toISOString()
        });

        alert(`Заказ оформлен! Сумма заказа: ${total.toLocaleString()} у.е.\nС вами свяжется наш менеджер в ближайшее время.`);

        // Очищаем корзину после оформления заказа
        cart = [];
        updateCart();
        storageManager.clearCart();
        closeCartModal();
    });

    // Инициализация приложения
    initializeAddToCartButtons();
    updateCart();

    // Восстанавливаем корзину при загрузке страницы
    alert('Корзина восстановлена:', cart);
});