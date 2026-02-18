<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Core\Session;
use App\Repositories\ClientRepository;

final class ProfileController extends Controller
{
    public function get(): void
    {
        $this->requireMethod('GET');
        $clientId = Session::requireClientId();

        $repo = new ClientRepository($this->pdo);
        $u = $repo->findById($clientId);
        if (!$u)
            Response::fail('Пользователь не найден', 404);

        Response::ok([
            'profile' => [
                'id' => (int) $u['id_клиента'],
                'name' => (string) $u['Имя'],
                'lastName' => (string) $u['Фамилия'],
                'email' => (string) $u['email'],
                'phone' => (string) ($u['Телефон'] ?? ''),
                'address' => (string) ($u['Адрес'] ?? ''),
            ]
        ]);
    }

    public function update(): void
    {
        $this->requireMethod('POST');
        $clientId = Session::requireClientId();

        $name = trim((string) ($this->req->json['name'] ?? ''));
        $lastName = trim((string) ($this->req->json['lastName'] ?? ''));
        $phone = trim((string) ($this->req->json['phone'] ?? ''));
        $address = trim((string) ($this->req->json['address'] ?? ''));

        if ($name === '' || $lastName === '')
            Response::fail('Имя и фамилия обязательны');

        $repo = new ClientRepository($this->pdo);
        $repo->updateProfile($clientId, $name, $lastName, ($phone ?: null), ($address ?: null));

        Response::ok(['updated' => true]);
    }
}
