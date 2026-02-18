<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

final class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(Request $req, PDO $pdo): void
    {
        $method = $req->method;
        $path = rtrim($req->path, '/') ?: '/';

        // 1) Сначала пробуем точное совпадение
        $handler = $this->routes[$method][$path] ?? null;
        $params = [];

        // 2) Если точного нет — пробуем маршруты с {param}
        if (!$handler) {
            foreach ($this->routes[$method] as $routePath => $routeHandler) {
                if (strpos($routePath, '{') === false)
                    continue;

                // /api/orders/{id}/receipt -> #^/api/orders/(?P<id>[^/]+)/receipt$#
                $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routePath);
                $regex = '#^' . rtrim($regex, '/') . '$#';

                if (preg_match($regex, $path, $m)) {
                    $handler = $routeHandler;
                    foreach ($m as $k => $v) {
                        if (!is_int($k))
                            $params[$k] = $v;
                    }
                    break;
                }
            }
        }

        if (!$handler) {
            Response::fail('Not found', 404, ['path' => $path, 'method' => $method]);
        }

        // Подмешаем params в query, чтобы можно было взять $req->getInt('id')
        $mergedQuery = array_merge($req->query, $params);
        $req2 = new Request($req->method, $req->path, $mergedQuery, $req->json);

        [$class, $action] = $handler;
        $controller = new $class($pdo, $req2);
        $controller->$action();
    }
}
