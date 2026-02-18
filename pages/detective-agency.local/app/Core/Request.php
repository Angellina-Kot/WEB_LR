<?php
declare(strict_types=1);

namespace App\Core;

final class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $query,
        public readonly array $json
    ) {
    }

    public static function fromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        $raw = file_get_contents('php://input') ?: '';
        $json = json_decode($raw, true);
        $json = is_array($json) ? $json : [];

        return new self($method, $path, $_GET, $json);
    }

    public function getInt(string $key, int $default = 0): int
    {
        if (!isset($this->query[$key]))
            return $default;
        $v = (int) $this->query[$key];
        return $v > 0 ? $v : $default;
    }

    public function getStr(string $key, string $default = ''): string
    {
        if (!isset($this->query[$key]))
            return $default;
        return trim((string) $this->query[$key]);
    }
}
