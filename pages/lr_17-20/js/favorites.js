// class FavoritesManager {
//     constructor() {
//         this.favorites = JSON.parse(localStorage.getItem('favorites')) || [];
//         this.services = [];
//         this.init();
//     }

//     async init() {
//         await this.loadServices();
//         this.renderServices();
//         this.setupEventListeners();
//         this.updateFavoritesCounter();
//     }

//     async loadServices() {
//         try {
//             const response = await fetch('./services.json');
//             const data = await response.json();
//             this.services = data.services;
//         } catch (error) {
//             console.error('Ошибка загрузки услуг:', error);
//             // Fallback - используем статические данные если JSON не загрузился
//             this.services = [
//                 {
//                     id: 1,
//                     title: "Работа с информацией",
//                     image: "./img/Работа_инф-я.png",
//                     price: "от 15 000 ₽",
//                     features: ["Поиск и проверка информации", "Составление персонального досье", "Работа с репутацией", "Информация по номеру телефона"]
//                 },
//                 // ... остальные услуги
//             ];
//         }
//     }

//     renderServices() {
//         const container = document.querySelector('.services__inner');
//         if (!container) return;

//         container.innerHTML = this.services.map(service => `
//             <div class="services__box" data-id="${service.id}">
//                 <img class="services__img" src="${service.image}" alt="${service.title}">
//                 <div class="service-price">${service.price}</div>
//                 <h4 class="services__text">${service.title}</h4>
//                 <ul class="services__box-list">
//                     ${service.features.map(feature => `
//                         <li class="services__box-item">${feature}</li>
//                     `).join('')}
//                 </ul>
//                 <div class="services__actions">
//                     <button class="btn-favorite ${this.isFavorite(service.id) ? 'active' : ''}" 
//                             onclick="favoritesManager.toggleFavorite(${service.id})"
//                             title="${this.isFavorite(service.id) ? 'Удалить из понравившихся' : 'Добавить в понравившиеся'}">
//                         ♥
//                     </button>
//                     <button class="btn btn-more" onclick="favoritesManager.showServiceDetails(${service.id})">
//                         Оформить заявку
//                     </button>
//                 </div>
//             </div>
//         `).join('');
//     }

//     toggleFavorite(serviceId) {
//         const index = this.favorites.indexOf(serviceId);

//         if (index > -1) {
//             this.favorites.splice(index, 1);
//         } else {
//             this.favorites.push(serviceId);
//         }

//         this.saveFavorites();
//         this.updateFavoritesCounter();
//         this.updateFavoriteButtons();

//         // Показываем уведомление
//         this.showFavoriteNotification(serviceId, index === -1);
//     }

//     isFavorite(serviceId) {
//         return this.favorites.includes(serviceId);
//     }

//     saveFavorites() {
//         localStorage.setItem('favorites', JSON.stringify(this.favorites));
//     }

//     updateFavoritesCounter() {
//         const counter = document.getElementById('favorites-counter');
//         if (counter) {
//             counter.textContent = this.favorites.length;
//             counter.style.display = this.favorites.length > 0 ? 'flex' : 'none';
//         }
//     }

//     updateFavoriteButtons() {
//         document.querySelectorAll('.btn-favorite').forEach(button => {
//             const serviceId = parseInt(button.closest('.services__box').dataset.id);
//             button.classList.toggle('active', this.isFavorite(serviceId));
//             button.title = this.isFavorite(serviceId) ? 'Удалить из понравившихся' : 'Добавить в понравившиеся';
//         });
//     }

//     showFavoriteNotification(serviceId, added) {
//         const service = this.services.find(s => s.id === serviceId);
//         const message = added ? 'Добавлено в понравившиеся' : 'Удалено из понравившихся';

//         // Создаем уведомление
//         const notification = document.createElement('div');
//         notification.className = `favorite-notification ${added ? 'added' : 'removed'}`;
//         notification.innerHTML = `
//             <span>${message}: ${service.title}</span>
//         `;

//         document.body.appendChild(notification);

//         // Автоматически удаляем уведомление через 3 секунды
//         setTimeout(() => {
//             notification.style.opacity = '0';
//             notification.style.transform = 'translateX(100%)';
//             setTimeout(() => notification.remove(), 300);
//         }, 3000);
//     }

//     showServiceDetails(serviceId) {
//         const service = this.services.find(s => s.id === serviceId);
//         if (service) {
//             alert(`Оформление заявки на услугу: ${service.title}\n\nЦена: ${service.price}\n\nДля оформления заявки свяжитесь с нами по телефону.`);
//         }
//     }

//     showFavorites() {
//         const favoriteServices = this.services.filter(service =>
//             this.favorites.includes(service.id)
//         );

//         if (favoriteServices.length === 0) {
//             alert('В понравившихся пока нет услуг');
//             return;
//         }

//         const favoritesList = favoriteServices.map(service =>
//             `• ${service.title} - ${service.price}`
//         ).join('\n');

//         alert(`Ваши понравившиеся услуги:\n\n${favoritesList}\n\nДля заказа свяжитесь с нами!`);
//     }

//     setupEventListeners() {
//         // Обработчики для кнопок слайдера
//         const prevBtn = document.querySelector('.prev-slide');
//         const nextBtn = document.querySelector('.next-slide');

//         if (prevBtn && nextBtn) {
//             prevBtn.addEventListener('click', () => this.scrollSlider(-1));
//             nextBtn.addEventListener('click', () => this.scrollSlider(1));
//         }
//     }

//     scrollSlider(direction) {
//         const container = document.querySelector('.services__inner');
//         const scrollAmount = 400;
//         container.scrollLeft += direction * scrollAmount;
//     }
// }

// // Добавляем стили для функционала "Понравившиеся"
// const favoriteStyles = `
//     .services__actions {
//         display: flex;
//         gap: 10px;
//         justify-content: center;
//         align-items: center;
//         margin-top: 20px;
//     }
    
//     .btn-favorite {
//         width: 45px;
//         height: 45px;
//         border-radius: 50%;
//         border: 2px solid #ddd;
//         background: white;
//         font-size: 18px;
//         cursor: pointer;
//         transition: all 0.3s ease;
//         display: flex;
//         align-items: center;
//         justify-content: center;
//     }
    
//     .btn-favorite:hover {
//         transform: scale(1.1);
//         border-color: #ff4757;
//     }
    
//     .btn-favorite.active {
//         background: #ff4757;
//         color: white;
//         border-color: #ff4757;
//     }
    
//     .service-price {
//         font-size: 18px;
//         font-weight: bold;
//         color: #2c3e50;
//         margin: 10px 0;
//         text-align: left;
//         padding: 5px 0;
//     }
    
//     .favorites-header {
//         display: flex;
//         align-items: center;
//         gap: 15px;
//         margin-bottom: 20px;
//     }
    
//     .btn-favorites-header {
//         background: var(--color1);
//         color: white;
//         border: none;
//         padding: 12px 24px;
//         border-radius: 30px;
//         cursor: pointer;
//         display: flex;
//         align-items: center;
//         gap: 8px;
//         font-size: 16px;
//         transition: all 0.3s ease;
//     }
    
//     .btn-favorites-header:hover {
//         background: var(--color4);
//         transform: translateY(-2px);
//     }
    
//     .favorites-counter {
//         background: #ff4757;
//         color: white;
//         border-radius: 50%;
//         width: 24px;
//         height: 24px;
//         display: none;
//         align-items: center;
//         justify-content: center;
//         font-size: 12px;
//         font-weight: bold;
//     }
    
//     .favorite-notification {
//         position: fixed;
//         top: 20px;
//         right: 20px;
//         background: white;
//         padding: 15px 20px;
//         border-radius: 10px;
//         box-shadow: 0 4px 12px rgba(0,0,0,0.15);
//         z-index: 1000;
//         border-left: 4px solid #ff4757;
//         transition: all 0.3s ease;
//     }
    
//     .favorite-notification.added {
//         border-left-color: #2ed573;
//     }
    
//     .favorite-notification.removed {
//         border-left-color: #ff4757;
//     }
    
//     .services__inner {
//         display: flex;
//         overflow-x: auto;
//         scroll-behavior: smooth;
//         gap: 20px;
//         padding: 20px 10px;
//         scrollbar-width: none;
//     }
    
//     .services__inner::-webkit-scrollbar {
//         display: none;
//     }
    
//     @media (max-width: 768px) {
//         .services__actions {
//             flex-direction: column;
//             gap: 8px;
//         }
        
//         .btn-favorite {
//             width: 40px;
//             height: 40px;
//             font-size: 16px;
//         }
//     }
// `;

// // Добавляем стили в документ
// const styleSheet = document.createElement('style');
// styleSheet.textContent = favoriteStyles;
// document.head.appendChild(styleSheet);

// // Добавляем кнопку понравившихся в шапку секции
// document.addEventListener('DOMContentLoaded', function () {
//     const servicesInfo = document.querySelector('.services__info');
//     if (servicesInfo) {
//         const favoritesBtn = document.createElement('button');
//         favoritesBtn.className = 'btn-favorites-header';
//         favoritesBtn.innerHTML = `
//             ♥ Понравившиеся <span id="favorites-counter" class="favorites-counter"></span>
//         `;
//         favoritesBtn.onclick = () => favoritesManager.showFavorites();

//         // Вставляем кнопку перед стрелками
//         servicesInfo.insertBefore(favoritesBtn, servicesInfo.querySelector('.services__arrow'));
//     }
// });

// // Инициализация менеджера понравившихся
// const favoritesManager = new FavoritesManager();