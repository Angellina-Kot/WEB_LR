<?php
declare(strict_types=1);

$config = require __DIR__ . '/config/config.php';

require __DIR__ . '/app/Core/Cors.php';
require __DIR__ . '/app/Core/Session.php';
require __DIR__ . '/app/Core/DB.php';
require __DIR__ . '/app/Core/Request.php';
require __DIR__ . '/app/Core/Response.php';
require __DIR__ . '/app/Core/Router.php';
require __DIR__ . '/app/Core/Controller.php';

require __DIR__ . '/app/Repositories/ServiceRepository.php';
require __DIR__ . '/app/Repositories/ClientRepository.php';
require __DIR__ . '/app/Repositories/OrderRepository.php';
require __DIR__ . '/app/Repositories/TestimonialRepository.php';

require __DIR__ . '/app/Controllers/ServicesController.php';
require __DIR__ . '/app/Controllers/CategoriesController.php';
require __DIR__ . '/app/Controllers/OrdersController.php';
require __DIR__ . '/app/Controllers/TestimonialsController.php';
require __DIR__ . '/app/Controllers/StatisticsController.php';
require __DIR__ . '/app/Controllers/AuthController.php';
require __DIR__ . '/app/Controllers/ProfileController.php';
require __DIR__ . '/app/Controllers/AdminController.php';
require __DIR__ . '/app/Controllers/ReceiptController.php';


use App\Core\Cors;
use App\Core\Session;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

Cors::handlePreflight();
Session::start($config['session']);

$pdo = DB::pdo($config['db']);
$request = Request::fromGlobals();

$router = new Router();

// ===== Routes (MVC Controllers) =====
$router->get('/api/services', [App\Controllers\ServicesController::class, 'index']);
$router->get('/api/categories', [App\Controllers\CategoriesController::class, 'index']);
$router->post('/api/orders', [App\Controllers\OrdersController::class, 'create']);
$router->get('/api/orders/my', [App\Controllers\OrdersController::class, 'my']);
$router->get('/api/testimonials', [App\Controllers\TestimonialsController::class, 'index']);
$router->get('/api/statistics', [App\Controllers\StatisticsController::class, 'index']);

$router->post('/api/auth/register', [App\Controllers\AuthController::class, 'register']);
$router->post('/api/auth/login', [App\Controllers\AuthController::class, 'login']);
$router->post('/api/auth/logout', [App\Controllers\AuthController::class, 'logout']);
$router->get('/api/auth/me', [App\Controllers\AuthController::class, 'me']);

// Совместимость со старыми путями из фронта:
$router->post('/api/auth_register.php', [App\Controllers\AuthController::class, 'register']);
$router->post('/api/auth_login.php', [App\Controllers\AuthController::class, 'login']);
$router->post('/api/auth_logout.php', [App\Controllers\AuthController::class, 'logout']);
$router->get('/api/auth_me.php', [App\Controllers\AuthController::class, 'me']);

$router->get('/api/profile', [App\Controllers\ProfileController::class, 'get']);
$router->post('/api/profile/update', [App\Controllers\ProfileController::class, 'update']);

$router->get('/admin/check_session.php', [App\Controllers\AdminController::class, 'checkSession']);
$router->get('/orders/{id}/receipt', [\App\Controllers\ReceiptController::class, 'download']);
$router->get('/api/orders/{id}/receipt', [\App\Controllers\ReceiptController::class, 'download']);

try {
    $router->dispatch($request, $pdo);
} catch (Throwable $e) {
    Response::fail('Server error', 500, ['details' => $e->getMessage()]);
}
