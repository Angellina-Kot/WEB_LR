
// Глобальная переменная для хранения данных об услугах
let servicesData = {};
let cart = []; // Выносим cart в глобальную область видимости

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
                console.log('Корзина загружена из хранилища:', cart);
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
    // Загружаем корзину из хранилища ДО загрузки данных об услугах
    cart = storageManager.loadCart();
    console.log('Корзина восстановлена:', cart);

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
    const clearCartBtn = document.getElementById('clear-cart');

    // Инициализация кнопок "Добавить в корзину"
    function initializeAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.btn-more');

        addToCartButtons.forEach(button => {
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
                    addedAt: new Date().toISOString()
                });
            }

            updateCart();
            // showNotification('Товар добавлен в корзину!');

            // Сохраняем корзину после добавления товара
            storageManager.saveCart(cart);
        } else {
            console.error('Услуга с ID', serviceId, 'не найдена');
        }
    }

    // Функция удаления услуги из корзины
    function removeFromCart(serviceId) {
        cart = cart.filter(item => item.id !== serviceId);
        updateCart();
        showNotification('Товар удален из корзины');

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
        if (!cartItems) {
            console.error('Элемент cart-items не найден');
            return;
        }

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
                        <div class="item-price">${item.price.toLocaleString()} у.е.  x${item.quantity}</div>
                        
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


        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        if (cartTotal) {
            cartTotal.textContent = `Итого: ${total.toLocaleString()} у.е.`;
        }

        const totalCount = cart.reduce((count, item) => count + item.quantity, 0);
        if (cartCount) {
            cartCount.textContent = totalCount;
        }
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
        notification.style.display = 'block';
        notification.classList.add('active');

        setTimeout(() => {
            notification.style.display = 'none';
            notification.classList.remove('active');
        }, 3000);
    }

    // Функция открытия модального окна корзины
    function openCartModal() {
        if (cartModal) {
            cartModal.classList.add('active');
        }
    }

    // Функция закрытия модального окна корзины
    function closeCartModal() {
        if (cartModal) {
            cartModal.classList.remove('active');
        }
    }

    // Обработчики событий
    if (cartTrigger) {
        cartTrigger.addEventListener('click', openCartModal);
    }

    if (closeCart) {
        closeCart.addEventListener('click', closeCartModal);
    }

    if (continueBtn) {
        continueBtn.addEventListener('click', closeCartModal);
    }

    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', clearCart);
    }

    if (cartModal) {
        cartModal.addEventListener('click', function (e) {
            if (e.target === cartModal) {
                closeCartModal();
            }
        });
    }

    if (checkoutBtn) {
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
    }

    // Инициализация приложения
    initializeAddToCartButtons();
    updateCart(); // Обновляем корзину после инициализации
});