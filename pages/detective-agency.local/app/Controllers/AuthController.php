<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Repositories\ClientRepository;

final class AuthController extends Controller
{
    public function register(): void
    {
        $this->requireMethod('POST');

        $name = trim((string) ($this->req->json['name'] ?? ''));
        $lastName = trim((string) ($this->req->json['lastName'] ?? ''));
        $email = trim((string) ($this->req->json['email'] ?? ''));
        $password = (string) ($this->req->json['password'] ?? '');
        $phone = trim((string) ($this->req->json['phone'] ?? ''));
        $address = trim((string) ($this->req->json['address'] ?? ''));

        if ($name === '' || $lastName === '' || $email === '' || $password === '')
            Response::fail('Заполните обязательные поля');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            Response::fail('Некорректный email');
        if (strlen($password) < 6)
            Response::fail('Пароль должен быть не короче 6 символов');

        $repo = new ClientRepository($this->pdo);
        if ($repo->findByEmail($email))
            Response::fail('Email уже зарегистрирован');

        $id = $repo->create([
            'name' => $name,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $_SESSION['client_id'] = $id;

        Response::ok(['user' => ['id' => $id, 'name' => $name, 'lastName' => $lastName, 'email' => $email]]);
    }

    public function login(): void
    {
        $this->requireMethod('POST');

        $email = trim((string) ($this->req->json['email'] ?? ''));
        $password = (string) ($this->req->json['password'] ?? '');
        if ($email === '' || $password === '')
            Response::fail('Введите email и пароль');

        $repo = new ClientRepository($this->pdo);
        $u = $repo->findByEmail($email);

        if (!$u)
            Response::fail('Неверный email или пароль', 401);
        if (($u['Статус'] ?? '') === 'blocked')
            Response::fail('Аккаунт заблокирован', 403);
        if (!password_verify($password, (string) ($u['Пароль'] ?? '')))
            Response::fail('Неверный email или пароль', 401);

        $_SESSION['client_id'] = (int) $u['id_клиента'];

        Response::ok([
            'user' => [
                'id' => (int) $u['id_клиента'],
                'name' => (string) $u['Имя'],
                'lastName' => (string) $u['Фамилия'],
                'email' => (string) $u['email'],
                'status' => (string) ($u['Статус'] ?? 'active'),
                'isAdmin' => false
            ]
        ]);
    }

    public function me(): void
    {
        $this->requireMethod('GET');

        $cid = (int) ($_SESSION['client_id'] ?? 0);
        if ($cid <= 0)
            Response::ok(['user' => null]);

        $repo = new ClientRepository($this->pdo);
        $u = $repo->findById($cid);

        if (!$u) {
            unset($_SESSION['client_id']);
            Response::ok(['user' => null]);
        }

        Response::ok([
            'user' => [
                'id' => (int) $u['id_клиента'],
                'name' => (string) $u['Имя'],
                'lastName' => (string) $u['Фамилия'],
                'email' => (string) $u['email'],
                'phone' => $u['Телефон'] ?? null,
                'address' => $u['Адрес'] ?? null,
                'status' => (string) ($u['Статус'] ?? 'active'),
                'isAdmin' => false
            ]
        ]);
    }

    public function logout(): void
    {
        $this->requireMethod('POST');
        session_destroy();
        Response::ok();
    }
}
