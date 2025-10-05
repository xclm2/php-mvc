<?php
namespace App\Framework\Cache\Service;

use App\Framework\Cache\CacheInterface;

final class NullCacheService implements CacheInterface
{
    public function get(string $key): mixed
    {
        return null;
    }

    public function set(string $key, mixed $value, int $expiration): bool
    {
        return true;
    }

    public function flush(): bool
    {
        return true;
    }

    public function delete(string|array $key): bool
    {
        return true;
    }
}