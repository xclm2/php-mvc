<?php
namespace App\Framework\Cache;

interface CacheInterface
{
    public function get(string $key): mixed;
    public function set(string $key, mixed $value, int $expiration): bool;
    public function delete(string|array $key): bool;
    public function flush(): bool;
}