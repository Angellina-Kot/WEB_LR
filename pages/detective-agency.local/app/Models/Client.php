<?php
declare(strict_types=1);

namespace App\Models;

final class Client
{
    public function __construct(
        public int $id,
        public string $name,
        public string $lastName,
        public string $email,
        public ?string $phone,
        public ?string $address,
        public string $status
    ) {
    }
}
