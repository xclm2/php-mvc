<?php
namespace App\Framework\Cache;

use App\Framework\Traits\Cache\MonitorCache;
use App\Framework\Traits\Serialize;

class CacheManager implements CacheInterface
{   
    use Serialize, MonitorCache;

    public function __construct(protected CacheInterface $_cache) {}

    public function get(string $key): mixed 
    {
        return $this->_cache->get($key);
    }

    public function set(string $key, $value, int $expiration): bool
    {
        return $this->_cache->set($key, $value, $expiration);
    }

    public function flush(): bool
    {
        return $this->_cache->flush();
    }

    public function delete(string|array $key): bool
    {
        if (! is_array($key)) {
            return $this->_cache->delete($key);
        }

        $notDeleted = [];
        foreach ($key as $item) {
            if ($this->_cache->delete($item)) continue;

            $notDeleted[] = $item;
        }

        return count($notDeleted) != count($key);
    }
}