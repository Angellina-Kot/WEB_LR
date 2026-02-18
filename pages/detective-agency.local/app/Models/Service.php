<?php
declare(strict_types=1);

namespace App\Models;

final class Service
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public float $price,
        public string $image,
        public string $category,
        public ?int $performerId
    ) {
    }
}
