<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ClientRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $st = $this->pdo->prepare("SELECT * FROM `клиент` WHERE `email`=? LIMIT 1");
        $st->execute([$email]);
        $u = $st->fetch(PDO::FETCH_ASSOC);
        return $u ?: null;
    }

    public function findById(int $id): ?array
    {
        $st = $this->pdo->prepare("SELECT `id_клиента`,`Имя`,`Фамилия`,`email`,`Телефон`,`Адрес`,`Пароль`,`Статус` FROM `клиент` WHERE `id_клиента`=? LIMIT 1");
        $st->execute([$id]);
        $u = $st->fetch(PDO::FETCH_ASSOC);
        return $u ?: null;
    }

    public function create(array $data): int
    {
        $st = $this->pdo->prepare("
      INSERT INTO клиент (Имя, Фамилия, email, Телефон, Адрес, Пароль)
      VALUES (?, ?, ?, ?, ?, ?)
    ");
        $st->execute([
            $data['name'],
            $data['lastName'],
            $data['email'],
            $data['phone'] ?: null,
            $data['address'] ?: null,
            $data['hash']
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updateProfile(int $id, string $name, string $lastName, ?string $phone, ?string $address): void
    {
        $st = $this->pdo->prepare("
      UPDATE клиент SET Имя=?, Фамилия=?, Телефон=?, Адрес=? WHERE id_клиента=?
    ");
        $st->execute([$name, $lastName, $phone, $address, $id]);
    }
}
