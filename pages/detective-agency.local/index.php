<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adrasteia - Детективное агентство</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="icon" href="/favicon.ico?v=2">

    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-dark: #0a192f;
            --secondary-dark: #112240;
            --accent-blue: #64ffda;
            --accent-blue-light: #8892b0;
            --accent-blue-dark: #0d3b66;
            --light-gray: #ccd6f6;
            --transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --success: #00b894;
            --warning: #fdcb6e;
            --danger: #e17055;
        }

        body {
            background-color: var(--primary-dark);
            color: var(--light-gray);
            line-height: 1.6;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* Плавающие элементы фона */
        .background-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            opacity: 0.05;
            animation: float 20s infinite linear;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 5%;
            font-size: 8rem;
            color: var(--accent-blue);
            animation-delay: 0s;
            animation-duration: 25s;
        }

        .floating-element:nth-child(2) {
            top: 30%;
            right: 8%;
            font-size: 6rem;
            color: var(--accent-blue-light);
            animation-delay: 5s;
            animation-duration: 30s;
            animation-direction: reverse;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 15%;
            font-size: 7rem;
            color: var(--accent-blue);
            animation-delay: 10s;
            animation-duration: 35s;
        }

        .floating-element:nth-child(4) {
            top: 60%;
            right: 20%;
            font-size: 5rem;
            color: var(--accent-blue-light);
            animation-delay: 15s;
            animation-duration: 40s;
            animation-direction: reverse;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(20px, 30px) rotate(5deg);
            }

            50% {
                transform: translate(-15px, 40px) rotate(-5deg);
            }

            75% {
                transform: translate(30px, -20px) rotate(3deg);
            }

            100% {
                transform: translate(0, 0) rotate(0deg);
            }
        }

        /* Уведомления */
        .notification {
            position: fixed;
            top: 100px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 10px;
            z-index: 2000;
            transform: translateX(150%);
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            max-width: 350px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .notification.success {
            background: linear-gradient(45deg, var(--success), #00cec9);
            color: white;
        }

        .notification.error {
            background: linear-gradient(45deg, var(--danger), #ff7675);
            color: white;
        }

        .notification.warning {
            background: linear-gradient(45deg, var(--warning), #ffeaa7);
            color: #2d3436;
        }

        .notification.info {
            background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
            color: var(--primary-dark);
        }

        /* Лоадер */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 25, 47, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            width: 70px;
            height: 70px;
            border: 5px solid var(--accent-blue-dark);
            border-top-color: var(--accent-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Шапка */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--accent-blue-dark);
            transition: var(--transition);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
        }

        .logo-icon {
            color: var(--accent-blue);
            font-size: 2.2rem;
            filter: drop-shadow(0 0 5px rgba(100, 255, 218, 0.5));
            transition: var(--transition);
        }

        .logo:hover .logo-icon {
            transform: rotate(10deg);
            filter: drop-shadow(0 0 10px rgba(100, 255, 218, 0.7));
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--accent-blue), #4dabf7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: var(--light-gray);
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 0;
            position: relative;
            transition: var(--transition);
        }

        nav a:hover {
            color: var(--accent-blue);
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent-blue);
            transition: var(--transition);
        }

        nav a:hover::after {
            width: 100%;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .cart-btn {
            position: relative;
            background: transparent;
            border: none;
            color: var(--light-gray);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .cart-btn:hover {
            color: var(--accent-blue);
            transform: scale(1.1);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent-blue);
            color: var(--primary-dark);
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-btn {
            background: linear-gradient(45deg, var(--accent-blue-dark), #1e6091);
            color: white;
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(13, 59, 102, 0.3);
        }

        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(13, 59, 102, 0.5);
            background: linear-gradient(45deg, #1e6091, var(--accent-blue-dark));
        }

        .admin-btn {
            background: linear-gradient(45deg, #6c5ce7, #a29bfe);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .admin-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
        }

        /* Мобильное меню */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--accent-blue);
            font-size: 1.8rem;
            cursor: pointer;
        }

        /* Основной контент */
        main {
            margin-top: 100px;
            min-height: calc(100vh - 200px);
        }

        /* Герой секция */
        .hero {
            padding: 6rem 2rem;
            text-align: center;
            /* background: linear-gradient(rgba(10, 25, 47, 0.9), rgba(10, 25, 47, 0.97)); */
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(100, 255, 218, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(77, 171, 247, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--accent-blue), #a5d8ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.3rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            color: var(--accent-blue-light);
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .cta-button {
            background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
            color: var(--primary-dark);
            border: none;
            padding: 1.2rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(100, 255, 218, 0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(100, 255, 218, 0.5);
            letter-spacing: 1px;
        }

        .secondary-button {
            background: transparent;
            color: var(--accent-blue);
            border: 2px solid var(--accent-blue);
            padding: 1.2rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .secondary-button:hover {
            background: rgba(100, 255, 218, 0.1);
            transform: translateY(-5px);
        }

        /* Секции */
        .section {
            padding: 5rem 2rem;
            position: relative;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: var(--accent-blue);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 100px;
            height: 4px;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(to right, transparent, var(--accent-blue), transparent);
            border-radius: 2px;
        }

        /* Фильтры услуг */
        .filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: rgba(17, 34, 64, 0.7);
            color: var(--light-gray);
            border: 1px solid var(--accent-blue-dark);
            padding: 0.7rem 1.5rem;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .filter-btn.active {
            background: var(--accent-blue);
            color: var(--primary-dark);
            border-color: var(--accent-blue);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--accent-blue);
            color: var(--accent-blue);
            transform: translateY(-2px);
        }

        /* Карточки услуг */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .service-card {
            background: linear-gradient(145deg, rgba(17, 34, 64, 0.9), rgba(10, 25, 47, 0.9));
            border-radius: 20px;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid transparent;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .service-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-blue);
            box-shadow: 0 20px 50px rgba(100, 255, 218, 0.2);
        }

        .service-card.featured {
            border: 2px solid var(--accent-blue);
            position: relative;
        }

        .service-card.featured::before {
            content: 'ПОПУЛЯРНОЕ';
            position: absolute;
            top: 15px;
            right: -35px;
            background: var(--accent-blue);
            color: var(--primary-dark);
            padding: 5px 35px;
            transform: rotate(45deg);
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 1;
        }

        .service-image {
            height: 200px;
            width: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .service-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(10, 25, 47, 0.9));
        }

        .service-content {
            padding: 1.5rem;
        }

        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .service-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--accent-blue);
        }

        .service-category {
            font-size: 0.9rem;
            color: var(--accent-blue-light);
            background: rgba(100, 255, 218, 0.1);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            display: inline-block;
        }

        .service-description {
            color: var(--accent-blue-light);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .service-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .service-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.5rem;
            color: var(--accent-blue-light);
            font-size: 0.9rem;
        }

        .service-features i {
            color: var(--accent-blue);
            font-size: 0.8rem;
        }

        .service-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(100, 255, 218, 0.2);
        }

        .service-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent-blue);
        }

        .service-actions {
            display: flex;
            gap: 0.8rem;
        }

        .btn-add-to-cart {
            background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
            color: var(--primary-dark);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .btn-add-to-cart:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .btn-add-to-cart.in-cart {
            background: linear-gradient(45deg, var(--success), #00cec9);
        }

        .btn-details {
            background: transparent;
            border: 1px solid var(--accent-blue);
            color: var(--accent-blue);
            padding: 0.7rem 1.2rem;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-details:hover {
            background: rgba(100, 255, 218, 0.1);
        }

        /* Статистика */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            background: linear-gradient(to bottom, var(--primary-dark), var(--secondary-dark));
            border-radius: 30px;
            margin: 3rem;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            font-size: 3rem;
            color: var(--accent-blue);
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-blue);
            margin-bottom: 0.5rem;
        }

        .stat-text {
            color: var(--accent-blue-light);
            font-size: 1.1rem;
        }

        /* Слайдер отзывов */
        .testimonials-slider {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
        }

        .swiper {
            width: 100%;
            height: 400px;
            padding: 20px 0;
        }

        .testimonial-slide {
            background: linear-gradient(135deg, rgba(17, 34, 64, 0.9), rgba(10, 25, 47, 0.9));
            border-radius: 20px;
            padding: 3rem;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(100, 255, 218, 0.2);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3a86ff, #8338ec);
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
        }

        .testimonial-author {
            flex: 1;
        }

        .testimonial-author h4 {
            color: var(--accent-blue);
            margin-bottom: 0.3rem;
        }

        .testimonial-company {
            color: var(--accent-blue-light);
            font-size: 0.9rem;
        }

        .testimonial-rating {
            color: #fdcb6e;
            font-size: 1.2rem;
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--accent-blue-light);
            font-style: italic;
            position: relative;
            padding-left: 1.5rem;
        }

        .testimonial-text::before {
            content: '"';
            font-size: 4rem;
            color: var(--accent-blue);
            position: absolute;
            left: -10px;
            top: -20px;
            opacity: 0.3;
        }

        /* FAQ Аккордеон */
        .faq-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .accordion-item {
            background: rgba(17, 34, 64, 0.7);
            margin-bottom: 1rem;
            border-radius: 15px;
            overflow: hidden;
            border-left: 4px solid transparent;
            transition: var(--transition);
        }

        .accordion-item:hover {
            border-left-color: var(--accent-blue);
            transform: translateX(5px);
        }

        .accordion-header {
            padding: 1.5rem 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 25, 47, 0.5);
            transition: var(--transition);
        }

        .accordion-header:hover {
            background: rgba(100, 255, 218, 0.1);
        }

        .accordion-icon {
            color: var(--accent-blue);
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-size: 1.2rem;
        }

        .accordion-content {
            padding: 0 2rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .accordion-content p {
            padding: 1.5rem 0;
            color: var(--accent-blue-light);
            line-height: 1.7;
        }

        /* Корзина */
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1050;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .cart-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-modal {
            position: fixed;
            top: 0;
            right: -450px;
            width: 450px;
            height: 100vh;
            background-color: var(--secondary-dark);
            z-index: 1100;
            transition: right 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
        }

        .cart-modal.open {
            right: 0;
        }

        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--accent-blue-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h3 {
            font-size: 1.5rem;
            color: var(--accent-blue);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-cart {
            background: none;
            border: none;
            color: var(--light-gray);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-cart:hover {
            color: var(--accent-blue);
            transform: rotate(90deg);
        }

        .cart-items {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .cart-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--accent-blue-light);
        }

        .cart-empty i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--accent-blue-light);
            opacity: 0.5;
        }

        .cart-item {
            display: flex;
            background: rgba(10, 25, 47, 0.5);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
            align-items: center;
            border-left: 3px solid var(--accent-blue);
            transition: var(--transition);
        }

        .cart-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            margin-right: 1rem;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: var(--light-gray);
        }

        .cart-item-price {
            color: var(--accent-blue);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(100, 255, 218, 0.1);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
        }

        .quantity-btn {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: rgba(100, 255, 218, 0.2);
            border: none;
            color: var(--accent-blue);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background: rgba(100, 255, 218, 0.4);
            transform: scale(1.1);
        }

        .cart-item-total {
            margin-left: 1rem;
            font-weight: 700;
            color: var(--accent-blue);
            min-width: 80px;
            text-align: right;
        }

        .remove-item {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: 0.5rem;
            transition: var(--transition);
        }

        .remove-item:hover {
            color: #ff4757;
            transform: scale(1.1);
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--accent-blue-dark);
            background: rgba(10, 25, 47, 0.8);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .cart-total-amount {
            color: var(--accent-blue);
            font-size: 1.4rem;
        }

        .checkout-btn {
            width: 100%;
            background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
            color: var(--primary-dark);
            border: none;
            padding: 1rem;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .checkout-btn:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(100, 255, 218, 0.4);
        }

        .checkout-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Модальное окно оформления заказа */
        .checkout-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 500px;
            background: var(--secondary-dark);
            border-radius: 20px;
            padding: 1.5rem;
            z-index: 1200;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            display: none;
        }

        .checkout-modal.active {
            display: block;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .modal-header h3 {
            color: var(--accent-blue);
            font-size: 1.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            color: var(--light-gray);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--accent-blue-light);
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--accent-blue-dark);
            border-radius: 10px;
            color: var(--light-gray);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 2px rgba(100, 255, 218, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-submit {
            flex: 1;
            background: linear-gradient(45deg, var(--accent-blue), #4dabf7);
            color: var(--primary-dark);
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .btn-cancel {
            flex: 1;
            background: transparent;
            color: var(--light-gray);
            border: 1px solid var(--accent-blue-light);
            padding: 1rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Футер */
        footer {
            background-color: #050e1a;
            padding: 4rem 2rem 2rem;
            border-top: 1px solid var(--accent-blue-dark);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section h3 {
            color: var(--accent-blue);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .footer-section p {
            color: var(--accent-blue-light);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.8rem;
        }

        .footer-section a {
            color: var(--accent-blue-light);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-section a:hover {
            color: var(--accent-blue);
            padding-left: 5px;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .social-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--secondary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-blue);
            font-size: 1.2rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .social-icon:hover {
            background-color: var(--accent-blue);
            color: var(--primary-dark);
            transform: translateY(-5px);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--accent-blue-dark);
            color: var(--accent-blue-light);
            font-size: 0.9rem;
        }

        /* Адаптивность */
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 992px) {
            header {
                padding: 1rem;
            }

            nav ul {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2.8rem;
            }

            .section {
                padding: 4rem 1rem;
            }

            .stats {
                margin: 3rem 1rem;
            }

            .cart-modal {
                width: 100%;
                right: -100%;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            nav {
                position: fixed;
                top: 80px;
                left: 0;
                width: 100%;
                background: rgba(10, 25, 47, 0.98);
                padding: 1rem;
                display: none;
                z-index: 999;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }

            nav.active {
                display: block;
            }

            nav ul {
                flex-direction: column;
                gap: 0;
            }

            nav a {
                display: block;
                padding: 1rem;
                border-bottom: 1px solid rgba(100, 255, 218, 0.1);
            }

            .header-right {
                gap: 1rem;
            }

            .hero {
                padding: 4rem 1rem;
                margin-top: 80px;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .hero-buttons button {
                width: 100%;
                justify-content: center;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .service-actions {
                flex-direction: column;
            }

            .service-actions button {
                width: 100%;
                justify-content: center;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 2rem 1rem;
            }

            .testimonial-slide {
                padding: 2rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .logo-text {
                font-size: 1.5rem;
            }

            .auth-btn span {
                display: none;
            }

            .auth-btn {
                padding: 0.8rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .filters {
                gap: 0.5rem;
            }

            .filter-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .cart-modal {
                width: 100%;
            }

            .cart-item {
                flex-direction: column;
                align-items: stretch;
            }

            .cart-item-image {
                width: 100%;
                height: 150px;
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .cart-item-controls {
                justify-content: space-between;
                margin-top: 1rem;
            }
        }

        /* Анимации */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Специальные эффекты */
        .glow-text {
            text-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(100, 255, 218, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(100, 255, 218, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(100, 255, 218, 0);
            }
        }
    </style>
</head>

<body>
    <!-- Лоадер -->
    <div class="loader" id="pageLoader">
        <div class="spinner"></div>
    </div>

    <!-- Фоновые элементы -->
    <div class="background-elements">
        <i class="fas fa-search floating-element"></i>
        <i class="fas fa-user-secret floating-element"></i>
        <i class="fas fa-fingerprint floating-element"></i>
        <i class="fas fa-binoculars floating-element"></i>
    </div>

    <!-- Шапка -->
    <header>
        <div class="logo" onclick="scrollToTop()">
            <i class="fas fa-user-secret logo-icon"></i>
            <div class="logo-text">ADRASTEIA</div>
        </div>

        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <nav id="mainNav">
            <ul>
                <li><a href="#home" onclick="closeMobileMenu()">Главная</a></li>
                <li><a href="#services" onclick="closeMobileMenu()">Услуги</a></li>
                <li><a href="#testimonials" onclick="closeMobileMenu()">Отзывы</a></li>
                <li><a href="#faq" onclick="closeMobileMenu()">FAQ</a></li>
                <li><a href="#profile" id="profileNavLink" onclick="closeMobileMenu()" style="display:none;">Мой
                        профиль</a></li>
                <li><a href="#contacts" onclick="closeMobileMenu()">Контакты</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <button class="cart-btn" id="cartBtn">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="cartCount">0</span>
            </button>
            <a href="admin/" class="admin-btn" id="adminBtn" style="display: none;">
                <i class="fas fa-cog"></i>
                <span>Админка</span>
            </a>
            <a href="/profile.php" class="admin-btn" id="profileBtn" style="display:none;">
                <i class="fas fa-user"></i>
                <span>Мой профиль</span>
            </a>

            <button class="auth-btn" id="authBtn">
                <i class="fas fa-user-circle"></i>
                <span>Войти</span>
            </button>
        </div>
    </header>

    <!-- Корзина -->
    <div class="cart-overlay" id="cartOverlay"></div>
    <div class="cart-modal" id="cartModal">
        <div class="cart-header">
            <h3><i class="fas fa-shopping-cart"></i> Выбранные услуги</h3>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <div class="cart-empty" id="cartEmpty">
                <i class="fas fa-shopping-cart"></i>
                <p>Ваша корзина пуста</p>
                <p style="font-size: 0.9rem; margin-top: 0.5rem;">Добавьте услуги из каталога</p>
            </div>
        </div>
        <div class="cart-footer" id="cartFooter" style="display: none;">
            <div class="cart-total">
                <span>Общая сумма:</span>
                <span class="cart-total-amount" id="cartTotal">0 ₽</span>
            </div>
            <button class="checkout-btn" id="checkoutBtn">
                <i class="fas fa-lock"></i>
                Оформить заказ
            </button>
        </div>
    </div>

    <!-- Модальное окно оформления заказа -->
    <div class="checkout-modal" id="checkoutModal">
        <div class="modal-header">
            <h3>Оформление заказа</h3>
            <button class="close-modal" id="closeModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="checkoutForm">
            <div class="form-group">
                <label for="clientName">Ваше имя *</label>
                <input type="text" id="clientName" required>
            </div>
            <div class="form-group">
                <label for="clientPhone">Телефон *</label>
                <input type="tel" id="clientPhone" required>
            </div>
            <div class="form-group">
                <label for="clientEmail">Email *</label>
                <input type="email" id="clientEmail" required>
            </div>
            <div class="form-group">
                <label for="orderAddress">Адрес исполнения</label>
                <input type="text" id="orderAddress" placeholder="Если требуется выезд специалиста">
            </div>
            <div class="form-group">
                <label for="orderComment">Комментарий к заказу</label>
                <textarea id="orderComment" placeholder="Дополнительные пожелания или информация"></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-submit">Подтвердить заказ</button>
                <button type="button" class="btn-cancel" id="cancelCheckout">Отмена</button>
            </div>
        </form>
    </div>

    <div class="checkout-modal" id="confirmOrderModal" style="max-width:520px; display:none;">
        <div class="modal-header">
            <h3>Подтверждение заказа</h3>
            <button class="close-modal" id="closeConfirmOrder"><i class="fas fa-times"></i></button>
        </div>

        <div style="color: var(--accent-blue-light); line-height:1.7;">
            <p style="margin:0 0 .8rem 0;">Подтвердить оформление заказа?</p>

            <div
                style="background: rgba(10,25,47,.5); border:1px solid rgba(100,255,218,.15); border-radius:14px; padding:1rem;">
                <div style="display:flex; justify-content:space-between; gap:1rem;">
                    <span>Позиций:</span>
                    <strong id="confirmItemsCount"></strong>
                </div>
                <div style="display:flex; justify-content:space-between; gap:1rem; margin-top:.4rem;">
                    <span>Сумма:</span>
                    <strong style="color: var(--accent-blue);" id="confirmTotal"></strong>
                </div>
            </div>

            <p style="margin:.9rem 0 0 0; font-size:.95rem;">
                Нажмите <b>Подтвердить</b>, чтобы отправить заказ.
            </p>
        </div>

        <div class="modal-buttons" style="margin-top: 1.2rem;">
            <button type="button" class="btn-submit" id="confirmOrderYes">
                <i class="fas fa-check"></i> Подтвердить
            </button>
            <button type="button" class="btn-cancel" id="confirmOrderNo">Отмена</button>
        </div>
    </div>


    <!-- Основной контент -->
    <main>
        <!-- Герой секция -->
        <section class="hero" id="home">
            <h1>Детективное агентство "Adrasteia"</h1>
            <p>Профессиональные расследования, сбор информации и обеспечение безопасности. Работаем конфиденциально,
                результативно и в рамках закона.</p>
            <div class="hero-buttons">
                <button class="cta-button" onclick="scrollToServices()">
                    <i class="fas fa-search"></i>
                    Посмотреть услуги
                </button>
                <!-- <button class="secondary-button" onclick="showConsultationModal()">
                    <i class="fas fa-phone-alt"></i>
                    Бесплатная консультация
                </button> -->
            </div>
        </section>

        <!-- Секция услуг -->
        <section class="section" id="services">
            <h2 class="section-title">Наши услуги</h2>

            <!-- Фильтры -->
            <div class="filters" id="serviceFilters">
                <button class="filter-btn active" data-filter="all">Все услуги</button>
                <!-- Фильтры будут добавлены динамически -->
            </div>

            <!-- Сообщение о загрузке -->
            <div id="loadingServices" style="text-align: center; padding: 2rem;">
                <i class="fas fa-spinner fa-spin"
                    style="font-size: 2rem; color: var(--accent-blue); margin-bottom: 1rem;"></i>
                <p>Загрузка услуг...</p>
            </div>

            <!-- Сообщение об ошибке -->
            <div id="errorMessage" style="display: none; text-align: center; padding: 2rem;">
                <i class="fas fa-exclamation-triangle"
                    style="font-size: 2rem; color: var(--danger); margin-bottom: 1rem;"></i>
                <p>Ошибка загрузки услуг. Пожалуйста, попробуйте позже.</p>
                <button onclick="loadServices()" class="btn-add-to-cart" style="margin-top: 1rem;">
                    <i class="fas fa-redo"></i>
                    Попробовать снова
                </button>
            </div>

            <!-- Сетка услуг -->
            <div class="services-grid" id="servicesGrid" style="display: none;">
                <!-- Услуги будут загружены динамически -->
            </div>

            <!-- Кнопка "Показать еще" -->
            <div style="text-align: center; margin-top: 3rem; display: none;" id="loadMoreContainer">
                <button class="secondary-button" id="loadMoreBtn">
                    <i class="fas fa-plus"></i>
                    Показать еще услуги
                </button>
            </div>
        </section>

        <!-- Статистика -->
        <section class="section stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-number" id="completedCases">0</div>
                <div class="stat-text">Расследований завершено</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" id="happyClients">0</div>
                <div class="stat-text">Довольных клиентов</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-number" id="yearsExperience">0</div>
                <div class="stat-text">Лет на рынке</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number" id="successRate">0%</div>
                <div class="stat-text">Успешных дел</div>
            </div>
        </section>

        <!-- Слайдер отзывов -->
        <section class="section" id="testimonials">
            <h2 class="section-title">Отзывы клиентов</h2>
            <div class="testimonials-slider">
                <div class="swiper">
                    <div class="swiper-wrapper" id="testimonialsSlider">
                        <!-- Отзывы будут добавлены динамически -->
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        <!-- FAQ Аккордеон -->
        <section class="section" id="faq">
            <h2 class="section-title">Частые вопросы</h2>
            <div class="faq-container">
                <div class="accordion-item">
                    <div class="accordion-header">
                        Как начать сотрудничество с агентством?
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Свяжитесь с нами по телефону или через форму на сайте. Мы проведем первичную консультацию,
                            обсудим детали вашего дела и предложим оптимальный план действий с расчетом стоимости. Все
                            консультации проводятся бесплатно и конфиденциально.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        Гарантируете ли вы конфиденциальность?
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Да, мы заключаем договор о неразглашении информации. Все детективы агентства связаны
                            профессиональной тайной. Мы используем защищенные каналы связи и обеспечиваем полную
                            анонимность клиентов. Все данные шифруются и хранятся в защищенных хранилищах.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        Сколько времени занимает расследование?
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Сроки зависят от сложности дела. Простые задачи (например, проверка человека) занимают 3-5
                            дней. Сложные расследования могут длиться несколько недель. После первичного анализа мы
                            предоставляем примерные сроки и еженедельные отчеты о ходе расследования.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        Какие доказательства вы предоставляете?
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>В зависимости от типа расследования мы предоставляем фото- и видеоотчеты, документальные
                            доказательства, аудиозаписи (с соблюдением законодательства), подробные письменные отчеты.
                            Все доказательства имеют юридическую силу и могут использоваться в суде.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header">
                        Какова стоимость ваших услуг?
                        <i class="fas fa-chevron-down accordion-icon"></i>
                    </div>
                    <div class="accordion-content">
                        <p>Стоимость зависит от сложности и объема работы. После консультации мы составляем
                            индивидуальный расчет. Вы платите только за фактически выполненную работу. Возможна оплата
                            по этапам или единовременно по завершении расследования.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>




    <!-- Футер -->
    <footer id="contacts">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Adrasteia</h3>
                <p>Профессиональное детективное агентство. Работаем с 2010 года. Конфиденциальность гарантирована.</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-icon"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Контакты</h3>
                <ul>
                    <li>
                        <a href="tel:+71234567890">
                            <i class="fas fa-phone"></i>
                            <span>+375 (11) 111-11-11</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:info@adrasteia.ru">
                            <i class="fas fa-envelope"></i>
                            <span>info@adrasteia.ru</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Гродно, ул. Детективная, 15</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-clock"></i>
                            <span>Пн-Пт: 00:00-00:00, Сб: 10:00-18:00</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Быстрые ссылки</h3>
                <ul>
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Главная</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-right"></i> Услуги</a></li>
                    <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Отзывы</a></li>
                    <li><a href="#faq"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="#" onclick="openCart()"><i class="fas fa-chevron-right"></i> Корзина</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 Детективное агентство "Adrasteia". Все права защищены.</p>
            <p>Конфиденциальность гарантирована</p>
        </div>
    </footer>


    <!-- Модалка авторизации -->
    <!-- AUTH MODAL -->
    <div class="checkout-modal" id="authModal" style="max-width:560px;">
        <div class="modal-header">
            <h3 id="authTitle">Вход</h3>
            <button class="close-modal" id="closeAuthModal"><i class="fas fa-times"></i></button>
        </div>

        <div class="filters" style="justify-content:flex-start; margin-bottom:1.2rem;">
            <button class="filter-btn active" id="tabLogin" type="button">Вход</button>
            <button class="filter-btn" id="tabRegister" type="button">Регистрация</button>
        </div>

        <!-- LOGIN -->
        <form id="loginForm">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" id="loginEmail" required autocomplete="email">
            </div>
            <div class="form-group">
                <label>Пароль *</label>
                <input type="password" id="loginPassword" required autocomplete="current-password">
            </div>


            <div class="modal-buttons">
                <button type="submit" class="btn-submit">Войти</button>
                <button type="button" class="btn-cancel" id="cancelAuth">Отмена</button>
            </div>
        </form>

        <!-- REGISTER -->
        <form id="registerForm" style="display:none;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label>Имя *</label>
                    <input type="text" id="regName" required>
                </div>
                <div class="form-group">
                    <label>Фамилия *</label>
                    <input type="text" id="regLastName" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" id="regEmail" required>
            </div>

            <div class="form-group">
                <label>Телефон *</label>
                <input type="tel" id="regPhone" placeholder="+375 (__) ___-__-__" required>
            </div>

            <div class="form-group">
                <label>Адрес</label>
                <input id="regAddress"></input>
            </div>

            <div class="form-group">
                <label>Пароль *</label>
                <input type="password" id="regPassword" required minlength="6">
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn-submit">Создать аккаунт</button>
                <button type="button" class="btn-cancel" id="cancelAuth2">Отмена</button>
            </div>
        </form>

    </div>




    <!-- Библиотеки -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/inputmask@5.0.8/dist/inputmask.min.js"></script>

    <script>
        // ==================== функции для cookies ====================
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + encodeURIComponent(value) +
                '; expires=' + date.toUTCString() + '; path=/';
        }

        function getCookie(name) {
            const matches = document.cookie.match(
                new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)')
            );
            return matches ? decodeURIComponent(matches[1]) : null;
        }



        // ==================== МАСКА ВВОДА ТЕЛЕФОНА ====================
        document.addEventListener('DOMContentLoaded', () => {
            Inputmask({
                mask: "+375 (99) 999-99-99",
                showMaskOnHover: false,
                showMaskOnFocus: true
            }).mask("#regPhone");

            const savedEmail = getCookie('auth_email');
            const savedPassword = getCookie('auth_password');

            if (savedEmail && savedPassword) {
                const emailInput = document.getElementById('loginEmail');
                const passInput = document.getElementById('loginPassword');

                if (emailInput && passInput) {
                    emailInput.value = savedEmail;
                    passInput.value = savedPassword;
                }
            }
        });

        // ==================== КОНФИГУРАЦИЯ ====================
        const CONFIG = {
            API_URL: window.location.hostname === 'localhost'
                ? 'http://localhost/api'
                : '/api',
            DEBUG: true,
            ITEMS_PER_PAGE: 8,
            CART_KEY: 'adrasteia_cart_v2',
            FALLBACK_DATA: true
        };

        // ==================== ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ ====================
        let cart = [];
        let services = [];
        let currentFilter = 'all';
        let currentPage = 1;
        let isLoading = false;
        let hasMoreServices = true;
        let allCategories = ['all', 'surveillance', 'check', 'cyber', 'family', 'business', 'technical'];

        // ==================== DOM ЭЛЕМЕНТЫ ====================
        const elements = {
            // Лоадер
            loader: document.getElementById('pageLoader'),

            // Шапка
            menuToggle: document.getElementById('menuToggle'),
            mainNav: document.getElementById('mainNav'),
            cartBtn: document.getElementById('cartBtn'),
            cartCount: document.getElementById('cartCount'),
            authBtn: document.getElementById('authBtn'),
            adminBtn: document.getElementById('adminBtn'),

            // Корзина
            cartModal: document.getElementById('cartModal'),
            cartOverlay: document.getElementById('cartOverlay'),
            closeCart: document.getElementById('closeCart'),
            cartItems: document.getElementById('cartItems'),
            cartEmpty: document.getElementById('cartEmpty'),
            cartFooter: document.getElementById('cartFooter'),
            cartTotal: document.getElementById('cartTotal'),
            checkoutBtn: document.getElementById('checkoutBtn'),

            // Модальное окно
            checkoutModal: document.getElementById('checkoutModal'),
            closeModal: document.getElementById('closeModal'),
            cancelCheckout: document.getElementById('cancelCheckout'),
            checkoutForm: document.getElementById('checkoutForm'),

            // Услуги
            serviceFilters: document.getElementById('serviceFilters'),
            loadingServices: document.getElementById('loadingServices'),
            errorMessage: document.getElementById('errorMessage'),
            servicesGrid: document.getElementById('servicesGrid'),
            loadMoreContainer: document.getElementById('loadMoreContainer'),
            loadMoreBtn: document.getElementById('loadMoreBtn'),

            // Статистика
            completedCases: document.getElementById('completedCases'),
            happyClients: document.getElementById('happyClients'),
            yearsExperience: document.getElementById('yearsExperience'),
            successRate: document.getElementById('successRate'),

            // Слайдер
            testimonialsSlider: document.getElementById('testimonialsSlider'),
            // мой профиль
            profileBtn: document.getElementById('profileBtn'),

        };

        // ==================== API СЕРВИС ====================
        class ApiService {
            constructor() {
                this.baseUrl = CONFIG.API_URL;
            }

            async request(endpoint, method = 'GET', data = null) {
                const url = `${this.baseUrl}${endpoint}`;
                const options = {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                };

                if (data) {
                    options.body = JSON.stringify(data);
                }

                try {
                    const response = await fetch(url, options);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    return await response.json();
                } catch (error) {
                    console.error('API Error:', error);
                    throw error;
                }
            }

            async getServices(filters = {}) {
                const params = new URLSearchParams({
                    ...filters,
                    limit: CONFIG.ITEMS_PER_PAGE,
                    offset: ((filters.page || 1) - 1) * CONFIG.ITEMS_PER_PAGE
                }).toString();

                return this.request(`/services?${params}`);
            }

            async getCategories() {
                return this.request('/categories');
            }

            async createOrder(orderData) {
                return this.request('/orders', 'POST', orderData);
            }

            async getTestimonials() {
                return this.request('/testimonials');
            }

            async getStatistics() {
                return this.request('/statistics');
            }
        }

        // Инициализация API
        const api = new ApiService();

        // ==================== СИСТЕМА УВЕДОМЛЕНИЙ ====================
        class NotificationSystem {
            constructor() {
                this.container = document.createElement('div');
                this.container.style.cssText = `
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    z-index: 2000;
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                `;
                document.body.appendChild(this.container);
            }

            show(message, type = 'info', duration = 5000) {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.innerHTML = `
                    <i class="fas fa-${this.getIcon(type)}"></i>
                    <span>${message}</span>
                `;

                this.container.appendChild(notification);

                // Анимация появления
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 10);

                // Автоматическое скрытие
                setTimeout(() => {
                    this.hide(notification);
                }, duration);

                // Клик для закрытия
                notification.addEventListener('click', () => this.hide(notification));
            }

            hide(notification) {
                notification.style.transform = 'translateX(150%)';
                setTimeout(() => {
                    if (notification.parentNode === this.container) {
                        this.container.removeChild(notification);
                    }
                }, 500);
            }

            getIcon(type) {
                const icons = {
                    'success': 'check-circle',
                    'error': 'exclamation-circle',
                    'warning': 'exclamation-triangle',
                    'info': 'info-circle'
                };
                return icons[type] || 'info-circle';
            }
        }

        const notifications = new NotificationSystem();

        // ==================== СИСТЕМА КОРЗИНЫ ====================
        class CartSystem {
            constructor() {
                this.load();
            }

            load() {
                const saved = localStorage.getItem(CONFIG.CART_KEY);
                cart = saved ? JSON.parse(saved) : [];
                this.updateUI();
            }

            save() {
                localStorage.setItem(CONFIG.CART_KEY, JSON.stringify(cart));
                this.updateUI();
            }

            add(item, quantity = 1) {
                const existingIndex = cart.findIndex(cartItem => cartItem.id === item.id);

                if (existingIndex >= 0) {
                    cart[existingIndex].quantity += quantity;
                } else {
                    cart.push({
                        id: item.id,
                        name: item.название || item.name,
                        price: item.базовая_цена || item.price,
                        image: item.фото_url || item.image,
                        category: item.категория || item.category,
                        quantity
                    });
                }

                this.save();
                // notifications.show(`"${item.название || item.name}" добавлен в корзину`, 'success');
            }

            remove(id) {
                const item = cart.find(item => item.id === id);
                if (item) {
                    cart = cart.filter(item => item.id !== id);
                    this.save();
                    // notifications.show(`"${item.name}" удален из корзины`, 'info');
                }
            }

            updateQuantity(id, quantity) {
                if (quantity < 1) {
                    this.remove(id);
                    return;
                }

                const itemIndex = cart.findIndex(item => item.id === id);
                if (itemIndex >= 0) {
                    cart[itemIndex].quantity = quantity;
                    this.save();
                }
            }

            clear() {
                cart = [];
                this.save();
            }

            getTotal() {
                return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            }

            getCount() {
                return cart.reduce((count, item) => count + item.quantity, 0);
            }

            updateUI() {
                // Обновляем счетчик в шапке
                elements.cartCount.textContent = this.getCount();

                // Обновляем содержимое корзины
                this.renderCartItems();

                // Обновляем кнопки в карточках услуг
                this.updateServiceButtons();
            }

            renderCartItems() {
                if (cart.length === 0) {
                    elements.cartEmpty.style.display = 'block';
                    elements.cartFooter.style.display = 'none';
                    elements.cartItems.innerHTML = '';
                    return;
                }

                elements.cartEmpty.style.display = 'none';
                elements.cartFooter.style.display = 'block';

                let html = '';
                let total = 0;

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    html += `
                        <div class="cart-item" data-id="${item.id}">
                            <div class="cart-item-image" style="background-image: url('${item.image}')"></div>
                            <div class="cart-item-details">
                                <div class="cart-item-title">${item.name}</div>
                                <div class="cart-item-price">${item.price.toLocaleString()} ₽</div>
                            </div>
                            <div class="cart-item-controls">
                                <div class="cart-item-quantity">
                                    <button class="quantity-btn minus" onclick="cartSystem.updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                                    <span>${item.quantity}</span>
                                    <button class="quantity-btn plus" onclick="cartSystem.updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                                </div>
                                <div class="cart-item-total">${itemTotal.toLocaleString()} ₽</div>
                                <button class="remove-item" onclick="cartSystem.remove(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });

                elements.cartItems.innerHTML = html;
                elements.cartTotal.textContent = `${total.toLocaleString()} ₽`;
            }

            updateServiceButtons() {
                document.querySelectorAll('.btn-add-to-cart').forEach(button => {
                    const serviceId = parseInt(button.dataset.id);
                    const inCart = cart.some(item => item.id === serviceId);

                    if (inCart) {
                        button.innerHTML = '<i class="fas fa-check"></i> Выбрано';
                        button.classList.add('in-cart');
                    } else {
                        button.innerHTML = '<i class="fas fa-cart-plus"></i> Выбрать';
                        button.classList.remove('in-cart');
                    }
                });
            }
        }

        const cartSystem = new CartSystem();

        // ==================== СИСТЕМА УСЛУГ ====================
        class ServiceSystem {
            constructor() {
                this.currentPage = 1;
                this.hasMore = true;
                this.isLoading = false;
            }

            async loadServices(filter = 'all', reset = false) {
                if (this.isLoading) return;

                if (reset) {
                    this.currentPage = 1;
                    this.hasMore = true;
                    elements.servicesGrid.style.display = 'none';
                    elements.loadingServices.style.display = 'block';
                    elements.errorMessage.style.display = 'none';
                    elements.loadMoreContainer.style.display = 'none';
                }

                this.isLoading = true;

                try {
                    const filters = {
                        category: filter !== 'all' ? filter : null,
                        page: this.currentPage
                    };

                    const response = await api.getServices(filters);

                    if (response.success) {
                        if (reset) {
                            services = response.data;
                        } else {
                            services = [...services, ...response.data];
                        }

                        this.hasMore = response.pagination?.has_more || false;
                        this.renderServices();
                        this.updateFilters();

                        if (reset) {
                            elements.servicesGrid.style.display = 'grid';
                            elements.loadingServices.style.display = 'none';
                        }

                        if (this.hasMore) {
                            elements.loadMoreContainer.style.display = 'block';
                        }
                    } else {
                        throw new Error(response.message || 'Ошибка загрузки услуг');
                    }
                } catch (error) {
                    console.error('Error loading services:', error);

                    if (CONFIG.FALLBACK_DATA && services.length === 0) {
                        this.loadFallbackData();
                        // notifications.show('Используются демонстрационные данные', 'warning');
                    } else if (reset) {
                        elements.loadingServices.style.display = 'none';
                        elements.errorMessage.style.display = 'block';
                        // notifications.show('Ошибка загрузки услуг', 'error');
                    }
                } finally {
                    this.isLoading = false;
                }
            }

            loadFallbackData() {
                // Демонстрационные данные
                services = [
                    {
                        id: 1,
                        название: "Наблюдение и слежка",
                        описание: "Дискретное наблюдение за объектами, фиксация действий и перемещений",
                        категория: "surveillance",
                        базовая_цена: 25000,
                        фото_url: "https://images.unsplash.com/photo-1558618666-fcd25c85cd64",
                        срок_исполнения_days: 7,
                        сложность: "medium",
                        популярность: 150
                    },
                    {
                        id: 2,
                        название: "Проверка персонала",
                        описание: "Комплексная проверка биографии и репутации сотрудников",
                        категория: "check",
                        базовая_цена: 18000,
                        фото_url: "https://images.unsplash.com/photo-1551836026-d5c2c0b4d4a9",
                        срок_исполнения_days: 5,
                        сложность: "low",
                        популярность: 120
                    },
                    {
                        id: 3,
                        название: "Кибер-расследование",
                        описание: "Расследование киберпреступлений и поиск цифровых следов",
                        категория: "cyber",
                        базовая_цена: 35000,
                        фото_url: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31",
                        срок_исполнения_days: 14,
                        сложность: "high",
                        популярность: 95
                    },
                    {
                        id: 4,
                        название: "Семейные дела",
                        описание: "Установление фактов супружеской неверности, поиск родственников",
                        категория: "family",
                        базовая_цена: 22000,
                        фото_url: "https://images.unsplash.com/photo-1589829545856-d10d557cf95f",
                        срок_исполнения_days: 10,
                        сложность: "medium",
                        популярность: 110
                    },
                    {
                        id: 5,
                        название: "Бизнес-разведка",
                        описание: "Сбор информации о конкурентах, проверка деловых партнеров",
                        категория: "business",
                        базовая_цена: 45000,
                        фото_url: "https://images.unsplash.com/photo-1553877522-43269d4ea984",
                        срок_исполнения_days: 21,
                        сложность: "high",
                        популярность: 85
                    },
                    {
                        id: 6,
                        название: "Поиск пропавших лиц",
                        описание: "Профессиональный поиск пропавших без вести людей",
                        категория: "family",
                        базовая_цена: 30000,
                        фото_url: "https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0",
                        срок_исполнения_days: 14,
                        сложность: "high",
                        популярность: 75
                    },
                    {
                        id: 7,
                        название: "Защита от шпионажа",
                        описание: "Обнаружение и нейтрализация устройств прослушки",
                        категория: "technical",
                        базовая_цена: 28000,
                        фото_url: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32",
                        срок_исполнения_days: 3,
                        сложность: "medium",
                        популярность: 65
                    },
                    {
                        id: 8,
                        название: "Детектор лжи",
                        описание: "Проведение полиграфных проверок",
                        категория: "check",
                        базовая_цена: 15000,
                        фото_url: "https://images.unsplash.com/photo-1581094794329-c8112a89af12",
                        срок_исполнения_days: 1,
                        сложность: "low",
                        популярность: 140
                    }
                ];

                this.renderServices();
                this.updateFilters();
                elements.servicesGrid.style.display = 'grid';
                elements.loadingServices.style.display = 'none';
            }

            renderServices() {
                if (services.length === 0) {
                    elements.servicesGrid.innerHTML = `
                        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                            <i class="fas fa-search" style="font-size: 3rem; color: var(--accent-blue-light); opacity: 0.5; margin-bottom: 1rem;"></i>
                            <p>Услуги не найдены</p>
                        </div>
                    `;
                    return;
                }

                const categoryNames = {
                    'surveillance': 'Наблюдение',
                    'check': 'Проверки',
                    'cyber': 'Кибер-расследования',
                    'family': 'Семейные дела',
                    'business': 'Бизнес-разведка',
                    'technical': 'Технические',
                    'legal': 'Юридические'
                };

                let html = '';

                services.forEach((service, index) => {
                    const isFeatured = index < 2; // Первые 2 услуги помечаем как популярные
                    const inCart = cart.some(item => item.id === service.id);

                    html += `
                        <div class="service-card ${isFeatured ? 'featured' : ''}" style="animation-delay: ${index * 0.1}s">
                            <div class="service-image" style="background-image: url('${service.фото_url}')">
                                <div class="service-overlay"></div>
                            </div>
                            <div class="service-content">
                                <div class="service-header">
                                    <div>
                                        <h3 class="service-title">${service.название}</h3>
                                        <span class="service-category">${categoryNames[service.категория] || service.категория}</span>
                                    </div>
                                </div>
                                <p class="service-description">${service.описание}</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-clock"></i> Срок: ${service.срок_исполнения_days} дней</li>
                                    <li><i class="fas fa-chart-bar"></i> Сложность: ${service.сложность === 'high' ? 'Высокая' : service.сложность === 'medium' ? 'Средняя' : 'Низкая'}</li>
                                    <li><i class="fas fa-star"></i> Популярность: ${service.популярность || 0}</li>
                                </ul>
                                <div class="service-footer">
                                    <div class="service-price">${service.базовая_цена.toLocaleString()} ₽</div>
                                    <div class="service-actions">
                                        <button class="btn-add-to-cart ${inCart ? 'in-cart' : ''}" data-id="${service.id}">
                                            <i class="fas ${inCart ? 'fa-check' : 'fa-cart-plus'}"></i>
                                            ${inCart ? 'В корзине' : 'В корзину'}
                                        </button>
                                        <button class="btn-details" onclick="showServiceDetails(${service.id})">
                                            <i class="fas fa-info-circle"></i>
                                            Подробнее
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                elements.servicesGrid.innerHTML = html;

                // Добавляем обработчики для кнопок добавления в корзину
                document.querySelectorAll('.btn-add-to-cart').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const serviceId = parseInt(button.dataset.id);
                        const service = services.find(s => s.id === serviceId);

                        if (service) {
                            cartSystem.add(service);

                            // Анимация кнопки
                            button.style.transform = 'scale(1.1)';
                            setTimeout(() => {
                                button.style.transform = 'scale(1)';
                            }, 300);
                        }
                    });
                });
            }

            updateFilters() {
                // Собираем уникальные категории из услуг
                const categories = ['all', ...new Set(services.map(s => s.категория).filter(Boolean))];

                const categoryNames = {
                    'surveillance': 'Наблюдение',
                    'check': 'Проверки',
                    'cyber': 'Кибер-расследования',
                    'family': 'Семейные дела',
                    'business': 'Бизнес-разведка',
                    'technical': 'Технические',
                    'all': 'Все услуги'
                };

                let html = '';
                categories.forEach(category => {
                    const name = categoryNames[category] || category;
                    html += `
                        <button class="filter-btn ${currentFilter === category ? 'active' : ''}" 
                                data-filter="${category}">
                            ${name}
                        </button>
                    `;
                });

                elements.serviceFilters.innerHTML = html;

                // Добавляем обработчики для фильтров
                document.querySelectorAll('.filter-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        const filter = button.dataset.filter;
                        currentFilter = filter;

                        // Обновляем активную кнопку
                        document.querySelectorAll('.filter-btn').forEach(btn => {
                            btn.classList.remove('active');
                        });
                        button.classList.add('active');

                        // Загружаем услуги с новым фильтром
                        this.loadServices(filter, true);

                        // Прокручиваем к услугам
                        scrollToServices();
                    });
                });
            }

            loadMore() {
                if (!this.isLoading && this.hasMore) {
                    this.currentPage++;
                    this.loadServices(currentFilter, false);
                }
            }
        }

        const serviceSystem = new ServiceSystem();

        // ==================== СИСТЕМА СЛАЙДЕРА ====================
        class TestimonialSystem {
            constructor() {
                this.swiper = null;
                this.testimonials = [];
            }

            async loadTestimonials() {
                try {
                    const response = await api.getTestimonials();

                    if (response.success) {
                        this.testimonials = response.data;
                    } else {
                        // Загружаем демонстрационные данные
                        this.loadFallbackTestimonials();
                    }
                } catch (error) {
                    console.error('Error loading testimonials:', error);
                    this.loadFallbackTestimonials();
                }

                this.renderTestimonials();
                this.initSwiper();
            }

            loadFallbackTestimonials() {
                this.testimonials = [
                    {
                        id: 1,
                        имя: "Александр",
                        фамилия: "Волков",
                        компания: "ТехноКорп",
                        текст: "Обращался в Adrasteia для проверки потенциального делового партнера. Результаты превзошли ожидания - обнаружили серьезные финансовые махинации, о которых мы даже не подозревали. Спасло компанию от многомиллионных убытков.",
                        оценка: 5,
                        аватар: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e"
                    },
                    {
                        id: 2,
                        имя: "Мария",
                        фамилия: "Семенова",
                        компания: "Частный клиент",
                        текст: "Помогли найти моего пропавшего брата, с которым не было связи 3 года. Полиция ничего не могла сделать, а детективы Adrasteia нашли его за 2 недели в другом городе. Огромное спасибо за профессионализм и человеческое отношение!",
                        оценка: 5,
                        аватар: "https://images.unsplash.com/photo-1494790108755-2616b612b786"
                    },
                    {
                        id: 3,
                        имя: "Дмитрий",
                        фамилия: "Козлов",
                        компания: "ТК 'Глобал'",
                        текст: "Заказывали комплексную проверку персонала для филиала в Казани. Выявили несколько сотрудников с поддельными дипломами и одного с криминальным прошлым. Теперь регулярно сотрудничаем для проверки ключевых сотрудников.",
                        оценка: 4,
                        аватар: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d"
                    }
                ];
            }

            renderTestimonials() {
                let html = '';

                this.testimonials.forEach(testimonial => {
                    const ratingStars = '★'.repeat(testimonial.оценка) + '☆'.repeat(5 - testimonial.оценка);

                    html += `
                        <div class="swiper-slide">
                            <div class="testimonial-slide">
                                <div class="testimonial-header">
                                    <div class="testimonial-avatar">${testimonial.инициалы}</div>

                                    <div class="testimonial-author">
                                        <h4>${testimonial.имя} ${testimonial.фамилия}</h4>
                                        <div class="testimonial-company">${testimonial.компания}</div>
                                    </div>
                                    <div class="testimonial-rating" title="Оценка: ${testimonial.оценка}/5">
                                        ${ratingStars}
                                    </div>
                                </div>
                                <p class="testimonial-text">${testimonial.текст}</p>
                            </div>
                        </div>
                    `;
                });

                elements.testimonialsSlider.innerHTML = html;
            }

            initSwiper() {
                this.swiper = new Swiper('.swiper', {
                    direction: 'horizontal',
                    loop: true,
                    slidesPerView: 1,
                    spaceBetween: 30,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                        }
                    }
                });
            }
        }

        const testimonialSystem = new TestimonialSystem();

        // ==================== СИСТЕМА СТАТИСТИКИ ====================
        class StatisticsSystem {
            constructor() {
                this.stats = {
                    completedCases: 1247,
                    happyClients: 893,
                    yearsExperience: 25,
                    successRate: 97
                };
            }

            async loadStatistics() {
                try {
                    const response = await api.getStatistics();
                    if (response.success) {
                        this.stats = response.data;
                    }
                } catch (error) {
                    console.error('Error loading statistics:', error);
                }

                this.animateStatistics();
            }

            animateStatistics() {
                this.animateCounter(elements.completedCases, this.stats.completedCases, 2000);
                this.animateCounter(elements.happyClients, this.stats.happyClients, 2000);
                this.animateCounter(elements.yearsExperience, this.stats.yearsExperience, 2000);

                // Для процентов отдельная логика
                let percent = 0;
                const interval = setInterval(() => {
                    percent += 1;
                    elements.successRate.textContent = percent + '%';
                    if (percent >= this.stats.successRate) {
                        clearInterval(interval);
                    }
                }, 20);
            }

            animateCounter(element, target, duration) {
                let start = 0;
                const increment = target / (duration / 16);

                const updateCounter = () => {
                    start += increment;
                    if (start < target) {
                        element.textContent = Math.floor(start).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = target.toLocaleString();
                    }
                };

                updateCounter();
            }
        }

        const statisticsSystem = new StatisticsSystem();

        // ==================== СИСТЕМА ЗАКАЗОВ ====================
        class OrderSystem {
            async createOrder(orderData) {
                try {
                    // Добавляем товары из корзины
                    orderData.items = cart.map(item => ({
                        id_услуги: item.id,
                        количество: item.quantity,
                        цена_единицы: item.price
                    }));

                    orderData.общая_сумма = cartSystem.getTotal();

                    const response = await api.createOrder(orderData);

                    if (response.success) {
                        // notifications.show(`Заказ #${response.data.id_заказа} успешно создан!`, 'success');

                        // Очищаем корзину
                        cartSystem.clear();

                        // Закрываем модальные окна
                        closeCart();
                        closeCheckoutModal();

                        return response.data;
                    } else {
                        throw new Error(response.message || 'Ошибка создания заказа');
                    }
                } catch (error) {
                    console.error('Error creating order:', error);
                    // notifications.show('Ошибка создания заказа. Попробуйте позже.', 'error');
                    throw error;
                }
            }
        }

        const orderSystem = new OrderSystem();

        // ==================== АККОРДЕОН ====================
        function initAccordion() {
            document.querySelectorAll('.accordion-header').forEach(header => {
                header.addEventListener('click', () => {
                    const item = header.parentElement;
                    const content = header.nextElementSibling;
                    const icon = header.querySelector('.accordion-icon');

                    // Закрываем все остальные
                    document.querySelectorAll('.accordion-content').forEach(otherContent => {
                        if (otherContent !== content && otherContent.style.maxHeight) {
                            otherContent.style.maxHeight = null;
                            otherContent.parentElement.querySelector('.accordion-icon').style.transform = 'rotate(0deg)';
                        }
                    });

                    // Переключаем текущий
                    if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Открываем первый элемент
            const firstHeader = document.querySelector('.accordion-header');
            if (firstHeader) {
                const firstContent = firstHeader.nextElementSibling;
                const firstIcon = firstHeader.querySelector('.accordion-icon');
                firstContent.style.maxHeight = firstContent.scrollHeight + 'px';
                firstIcon.style.transform = 'rotate(180deg)';
            }
        }

        // ==================== ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ====================
        function showServiceDetails(serviceId) {
            const service = services.find(s => s.id === serviceId);
            if (!service) return;

            const modalContent = `
                <div style="max-width: 600px; padding: 2rem; background: var(--secondary-dark); border-radius: 20px;">
                    <h3 style="color: var(--accent-blue); margin-bottom: 1rem;">${service.название}</h3>
                    <p style="color: var(--accent-blue-light); margin-bottom: 1.5rem; line-height: 1.6;">${service.описание}</p>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                        <div>
                            <strong style="color: var(--accent-blue);">Цена:</strong>
                            <div style="font-size: 1.5rem; color: var(--accent-blue); font-weight: bold;">
                                ${service.базовая_цена.toLocaleString()} ₽
                            </div>
                        </div>
                        <div>
                            <strong style="color: var(--accent-blue);">Срок:</strong>
                            <div style="font-size: 1.2rem; color: var(--light-gray);">
                                ${service.срок_исполнения_days} дней
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="cartSystem.add(${JSON.stringify(service).replace(/"/g, '&quot;')}); closeServiceModal()" 
                            style="width: 100%; background: linear-gradient(45deg, var(--accent-blue), #4dabf7); color: var(--primary-dark); border: none; padding: 1rem; border-radius: 10px; font-weight: bold; cursor: pointer; margin-top: 1rem;">
                        <i class="fas fa-cart-plus"></i> Добавить в корзину
                    </button>
                </div>
            `;

            // Создаем модальное окно
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 2000;
            `;
            modal.innerHTML = modalContent;
            modal.onclick = (e) => {
                if (e.target === modal) {
                    document.body.removeChild(modal);
                }
            };

            document.body.appendChild(modal);
        }

        function closeServiceModal() {
            const modal = document.querySelector('div[style*="position: fixed"][style*="background: rgba(0, 0, 0, 0.8)"]');
            if (modal) {
                document.body.removeChild(modal);
            }
        }

        function showConsultationModal() {
            // notifications.show('Функция консультации в разработке', 'info');
        }

        // ==================== ФУНКЦИИ КОРЗИНЫ ====================
        function openCart() {
            elements.cartModal.classList.add('open');
            elements.cartOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCart() {
            elements.cartModal.classList.remove('open');
            elements.cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // ==================== ФУНКЦИИ МОДАЛЬНОГО ОКНА ОФОРМЛЕНИЯ ====================
        function openCheckoutModal() {
            if (!currentUser) {
                notifications.show('Сначала войдите в аккаунт', 'warning');
                openAuthModal('login');
                return;
            }

            if (cart.length === 0) {
                notifications.show('Корзина пуста', 'warning');
                return;
            }

            elements.checkoutModal.classList.add('active');
            elements.cartOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }


        function closeCheckoutModal() {
            elements.checkoutModal.classList.remove('active');
            elements.cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // ==================== ФУНКЦИИ ПРОКРУТКИ ====================
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function scrollToServices() {
            const servicesSection = document.getElementById('services');
            if (servicesSection) {
                servicesSection.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function closeMobileMenu() {
            elements.mainNav.classList.remove('active');
            elements.menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
        }

        // ==================== ИНИЦИАЛИЗАЦИЯ ПРИ ЗАГРУЗКЕ ====================
        document.addEventListener('DOMContentLoaded', function () {
            // Скрываем лоадер
            setTimeout(() => {
                elements.loader.classList.add('hidden');
            }, 1000);

            // Инициализация аккордеона
            initAccordion();

            // Загрузка данных
            serviceSystem.loadServices('all', true);
            testimonialSystem.loadTestimonials();
            statisticsSystem.loadStatistics();

            // Проверка админ-доступа
            checkAdminAccess();

            // Плавная прокрутка для якорных ссылок
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });

                        closeMobileMenu();
                    }
                });
            });

            // Обработчик мобильного меню
            elements.menuToggle.addEventListener('click', () => {
                elements.mainNav.classList.toggle('active');
                elements.menuToggle.innerHTML = elements.mainNav.classList.contains('active')
                    ? '<i class="fas fa-times"></i>'
                    : '<i class="fas fa-bars"></i>';
            });

            // Обработчики корзины
            elements.cartBtn.addEventListener('click', openCart);
            elements.closeCart.addEventListener('click', closeCart);
            elements.cartOverlay.addEventListener('click', closeCart);
            elements.checkoutBtn.addEventListener('click', openCheckoutModal);

            // Обработчики модального окна оформления
            elements.closeModal.addEventListener('click', closeCheckoutModal);
            elements.cancelCheckout.addEventListener('click', closeCheckoutModal);
            elements.cartOverlay.addEventListener('click', function (e) {
                if (e.target === elements.cartOverlay && elements.checkoutModal.classList.contains('active')) {
                    closeCheckoutModal();
                }
            });

            // Обработчик формы оформления заказа
            elements.checkoutForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const orderData = {
                    client_name: document.getElementById('clientName').value,
                    client_phone: document.getElementById('clientPhone').value,
                    client_email: document.getElementById('clientEmail').value,
                    адрес_исполнения: document.getElementById('orderAddress').value || null,
                    комментарий_клиента: document.getElementById('orderComment').value || null
                };

                try {
                    await orderSystem.createOrder(orderData);
                } catch (error) {
                    // Ошибка уже обработана в orderSystem
                }
            });

            // Кнопка "Показать еще"
            elements.loadMoreBtn.addEventListener('click', () => {
                serviceSystem.loadMore();
            });

            // Кнопка входа/выхода
            // elements.authBtn.addEventListener('click', () => {
            //     if (authSystem.user) {
            //         // быстрый “меню-выход” без сложного UI:
            //         authSystem.logout();
            //     } else {
            //         authSystem.open('login');
            //     }
            // });
            // AUTH handlers
            authEls.close.addEventListener('click', closeAuthModal);
            authEls.cancel.addEventListener('click', closeAuthModal);
            authEls.cancel2.addEventListener('click', closeAuthModal);

            authEls.tabLogin.addEventListener('click', () => setAuthTab('login'));
            authEls.tabRegister.addEventListener('click', () => setAuthTab('register'));

            // закрытие по клику на overlay (чтобы не конфликтовать с корзиной/checkout)
            elements.cartOverlay.addEventListener('click', (e) => {
                if (e.target === elements.cartOverlay && authEls.modal.classList.contains('active')) {
                    closeAuthModal();
                }
            });

            // submit login
            authEls.loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const email = loginEmail.value.trim();
                const password = loginPassword.value;

                const res = await fetch('/api/auth_login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await res.json();

                if (!data.success) {
                    notifications.show(data.message, 'error');
                    return;
                }

                //  СОХРАНЕНИЕ В COOKIES
                setCookie('auth_email', email, 7);
                setCookie('auth_password', password, 7);

                notifications.show('Вы успешно вошли', 'success');
                closeAuthModal();
                location.reload();

                try {
                    await login(authEls.loginEmail.value.trim(), authEls.loginPassword.value);
                } catch (err) {
                    notifications.show(err.message || 'Ошибка входа', 'error');
                }
            });

            // submit register
            authEls.registerForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                try {
                    await registerUser(
                        authEls.regName.value.trim(),
                        authEls.regLastName.value.trim(),
                        authEls.regEmail.value.trim(),
                        authEls.regPassword.value,
                        authEls.regPhone.value.trim(),
                        authEls.regAddress.value.trim()
                    );

                } catch (err) {
                    notifications.show(err.message || 'Ошибка регистрации', 'error');
                }
            });

            // подтягиваем сессию при старте
            authMe();


            // Закрытие по ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (elements.cartModal.classList.contains('open')) {
                        closeCart();
                    }
                    if (elements.checkoutModal.classList.contains('active')) {
                        closeCheckoutModal();
                    }
                    if (authEls.modal.classList.contains('active')) {
                        closeAuthModal();
                    }
                }
            });
        });

        // ==================== ПРОВЕРКА АДМИН ДОСТУПА ====================
        async function checkAdminAccess() {
            try {
                // Проверяем наличие сессии админа
                const response = await fetch('admin/check_session.php', {
                    credentials: 'include'
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.isAdmin) {
                        elements.adminBtn.style.display = 'flex';
                    }
                }
            } catch (error) {
                // Если файл не существует или ошибка - скрываем кнопку
                elements.adminBtn.style.display = 'none';
            }
        }

        // ==================== АВТОСОХРАНЕНИЕ ====================
        window.addEventListener('beforeunload', () => {
            cartSystem.save();
        });

        // Делаем функции глобальными для HTML
        window.cartSystem = cartSystem;
        window.openCart = openCart;
        window.closeCart = closeCart;
        window.scrollToServices = scrollToServices;
        window.scrollToTop = scrollToTop;
        window.showServiceDetails = showServiceDetails;
        window.showConsultationModal = showConsultationModal;
        window.loadServices = () => serviceSystem.loadServices(currentFilter, true);

        // ==================== АВТОРИЗАЦИЯ ====================
        // ==================== AUTH ====================
        let currentUser = null;

        const authEls = {
            modal: document.getElementById('authModal'),
            title: document.getElementById('authTitle'),
            close: document.getElementById('closeAuthModal'),
            cancel: document.getElementById('cancelAuth'),
            cancel2: document.getElementById('cancelAuth2'),
            tabLogin: document.getElementById('tabLogin'),
            tabRegister: document.getElementById('tabRegister'),
            loginForm: document.getElementById('loginForm'),
            registerForm: document.getElementById('registerForm'),
            loginEmail: document.getElementById('loginEmail'),
            loginPassword: document.getElementById('loginPassword'),
            regName: document.getElementById('regName'),
            regLastName: document.getElementById('regLastName'),
            regEmail: document.getElementById('regEmail'),
            regPassword: document.getElementById('regPassword'),
            regPhone: document.getElementById('regPhone'),
            regAddress: document.getElementById('regAddress'),

        };

        function openAuthModal(mode = 'login') {
            authEls.modal.classList.add('active');
            elements.cartOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            setAuthTab(mode);
        }

        function closeAuthModal() {
            authEls.modal.classList.remove('active');
            elements.cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        function setAuthTab(mode) {
            const isLogin = mode === 'login';
            authEls.title.textContent = isLogin ? 'Вход' : 'Регистрация';

            authEls.tabLogin.classList.toggle('active', isLogin);
            authEls.tabRegister.classList.toggle('active', !isLogin);

            authEls.loginForm.style.display = isLogin ? 'block' : 'none';
            authEls.registerForm.style.display = !isLogin ? 'block' : 'none';
        }

        async function authMe() {
            // поддерживаем старый путь, который у тебя уже встречается в проекте
            const res = await fetch('/api/auth_me.php', { credentials: 'include' });
            const data = await res.json().catch(() => null);

            if (data && data.success && data.user) {
                currentUser = data.user;
                applyAuthUI();
            } else {
                currentUser = null;
                applyAuthUI();
            }
        }

        function applyAuthUI() {
            if (currentUser) {
                elements.authBtn.innerHTML = `<i class="fas fa-sign-out-alt"></i><span>Выйти</span>`;
                elements.authBtn.onclick = () => logout();

                if (elements.profileBtn) elements.profileBtn.style.display = 'flex';
            } else {
                elements.authBtn.innerHTML = `<i class="fas fa-user-circle"></i><span>Войти</span>`;
                elements.authBtn.onclick = () => openAuthModal('login');

                if (elements.profileBtn) elements.profileBtn.style.display = 'none';
            }
        }


        async function login(email, password) {
            const res = await fetch('/api/auth_login.php', {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            const data = await res.json().catch(() => null);
            if (!data || !data.success) throw new Error(data?.message || 'Ошибка входа');

            currentUser = data.user;
            applyAuthUI();
            closeAuthModal();
            notifications.show('Вы вошли в аккаунт', 'success');

            // можно автозаполнить форму заказа (если открыта)
            if (currentUser?.email) {
                const n = document.getElementById('clientName');
                const e = document.getElementById('clientEmail');
                if (n && !n.value) n.value = currentUser.name || '';
                if (e && !e.value) e.value = currentUser.email || '';
            }
        }

        async function registerUser(name, lastName, email, password, phone, address) {
            const res = await fetch('/api/auth_register.php', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name,
                    lastName,
                    email,
                    password,
                    phone,
                    address
                })
            });

            const data = await res.json();
            if (!data.success) {
                throw new Error(data.message || 'Ошибка регистрации');
            }

            currentUser = data.user;
            applyAuthUI();
            closeAuthModal();
            notifications.show('Аккаунт успешно создан', 'success');
        }


        async function logout() {
            await fetch('/api/auth_logout.php', {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({})
            }).catch(() => null);

            currentUser = null;
            applyAuthUI();
            notifications.show('Вы вышли из аккаунта', 'info');

            fetch('/api/auth_logout.php').then(() => {
                setCookie('auth_email', '', -1);
                setCookie('auth_password', '', -1);
                location.reload();
            });
        }



        // ===== Confirm Order Modal =====
        const confirmOrderEls = {
            modal: document.getElementById('confirmOrderModal'),
            close: document.getElementById('closeConfirmOrder'),
            no: document.getElementById('confirmOrderNo'),
            yes: document.getElementById('confirmOrderYes'),
            itemsCount: document.getElementById('confirmItemsCount'),
            total: document.getElementById('confirmTotal'),
        };

        function openConfirmOrderModal() {
            const itemsCount = cart.reduce((s, i) => s + i.quantity, 0);
            confirmOrderEls.itemsCount.textContent = itemsCount;
            confirmOrderEls.total.textContent = cartSystem.getTotal().toLocaleString('ru-RU') + ' ₽';

            confirmOrderEls.modal.style.display = 'block';
            confirmOrderEls.modal.classList.add('active');
            elements.cartOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeConfirmOrderModal() {
            confirmOrderEls.modal.classList.remove('active');
            confirmOrderEls.modal.style.display = 'none';
            elements.cartOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Переопределяем/заменяем openCheckoutModal: теперь он только подтверждает
        function openCheckoutModal() {
            if (!currentUser) {
                notifications.show('Сначала войдите в аккаунт', 'warning');
                openAuthModal('login');
                return;
            }
            if (cart.length === 0) {
                notifications.show('Корзина пуста', 'warning');
                return;
            }
            openConfirmOrderModal();
        }

        // Закрытия модалки подтверждения
        confirmOrderEls.close.addEventListener('click', closeConfirmOrderModal);
        confirmOrderEls.no.addEventListener('click', closeConfirmOrderModal);

        // Подтверждение: создаём заказ и показываем сообщение
        confirmOrderEls.yes.addEventListener('click', async () => {
            try {
                confirmOrderEls.yes.disabled = true;
                confirmOrderEls.yes.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Отправляем...';

                const payload = {
                    // адрес/комментарий не спрашиваем
                    address: null,
                    clientComment: null,
                    items: cart.map(item => ({
                        serviceId: item.id,
                        quantity: item.quantity
                    }))
                };

                const res = await fetch('/api/orders', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const data = await res.json().catch(() => null);
                if (!data || !data.success) throw new Error(data?.message || 'Ошибка оформления заказа');

                // УСПЕХ: очищаем корзину, закрываем окна, показываем сообщение
                cartSystem.clear();
                closeCart();                // закроет корзину, если открыта
                closeConfirmOrderModal();   // закроет подтверждение

                notifications.show('Ваш заказ оформлен. В ближайшее время с вами свяжется наш менеджер для уточнения деталей.', 'success', 7000);
            } catch (e) {
                console.error(e);
                notifications.show(e.message || 'Ошибка оформления заказа. Попробуйте позже.', 'error');
            } finally {
                confirmOrderEls.yes.disabled = false;
                confirmOrderEls.yes.innerHTML = '<i class="fas fa-check"></i> Подтвердить';
            }
        });

        // Если кликают на overlay — закрываем только confirm (и не ломаем корзину)
        elements.cartOverlay.addEventListener('click', () => {
            if (confirmOrderEls.modal && confirmOrderEls.modal.style.display === 'block') {
                closeConfirmOrderModal();
            }
        });

        // Обновляем глобальную функцию (если ты экспортируешь её)
        window.openCheckoutModal = openCheckoutModal;


        const authSystem = new AuthSystem();

        // Подхватываем сессию (если уже вошли ранее)
        authSystem.me();


    </script>
</body>

</html>