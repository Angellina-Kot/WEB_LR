<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Repositories\ServiceRepository;

final class ServicesController extends Controller
{
    public function index(): void
    {
        $this->requireMethod('GET');

        $category = $this->req->getStr('category', '');
        if ($category === 'null' || $category === 'undefined')
            $category = '';

        $limit = max(1, min(50, $this->req->getInt('limit', 8)));
        $page = $this->req->getInt('page', 0);
        $offset = $this->req->getInt('offset', 0);
        if ($page > 0)
            $offset = ($page - 1) * $limit;

        $repo = new ServiceRepository($this->pdo);
        $result = $repo->findActive($category, $limit, max(0, $offset));

        $total = $result['total'];
        $rows = $result['rows'];

        $data = [];
        foreach ($rows as $r) {
            $name = (string) $r['Название'];
            $desc = (string) ($r['Описание'] ?? '');
            $price = (float) $r['Цена'];
            $img = (string) ($r['Фото_услуги'] ?? '');
            $cat = (string) ($r['Категория'] ?? 'other');
            $perf = $r['id_исполнителя'] !== null ? (int) $r['id_исполнителя'] : null;

            $data[] = [
                'id' => (int) $r['id_услуги'],
                'name' => $name,
                'description' => $desc,
                'price' => $price,
                'image' => $img,
                'category' => $cat,
                'performerId' => $perf,

                // совместимость с твоим JS:
                'название' => $name,
                'описание' => $desc,
                'базовая_цена' => $price,
                'фото_url' => $img,
                'категория' => $cat,
                'срок_исполнения_days' => 7,
                'сложность' => 'medium',
                'популярность' => 0
            ];
        }

        $hasMore = ($offset + $limit) < $total;

        Response::ok([
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset,
                'has_more' => $hasMore,
            ],
        ]);
    }
}
