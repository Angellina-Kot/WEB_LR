<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Repositories\TestimonialRepository;

final class TestimonialsController extends Controller
{
    public function index(): void
    {
        $this->requireMethod('GET');

        $repo = new TestimonialRepository($this->pdo);
        $rows = $repo->approved(30);

        $data = [];

        foreach ($rows as $row) {

            $firstName = trim((string) ($row['Имя'] ?? ''));
            $lastName = trim((string) ($row['Фамилия'] ?? ''));

            // Если имя пустое — ставим "Клиент"
            if ($firstName === '') {
                $firstName = 'Клиент';
            }

            // Формируем инициалы
            $initials = mb_substr($firstName, 0, 1) .
                ($lastName !== '' ? mb_substr($lastName, 0, 1) : '');

            $data[] = [
                'id' => (int) $row['id_отзыва'],
                'имя' => $firstName,
                'фамилия' => $lastName,
                'инициалы' => mb_strtoupper($initials),
                'компания' => 'Частный клиент',
                'текст' => (string) $row['Текст'],
                'оценка' => (int) ($row['Оценка'] ?? 5),
            ];
        }

        Response::ok(['data' => $data]);
    }

}
