<?php
declare(strict_types=1);

namespace App\Models;

final class Order
{
    public function __construct(
        public int $id,
        public float $total,
        public string $status,
        public ?string $date
    ) {
    }
}
