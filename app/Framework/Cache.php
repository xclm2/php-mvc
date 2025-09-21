<?php
namespace App\Framework;

use App\Framework\Cache\CacheManager;
use App\Framework\Cache\Service\MemcachedService;
use App\Framework\Cache\Service\NullCacheService;

class Cache
{
    private static ?Cache $_instance = null;
    private $_cache;

    private function __construct()
    {
        $cache = match(env('CACHE_SERVICE')) {
            'memcached' => new MemcachedService(),
            default => new NullCacheService()
        };

        $this->_cache = new CacheManager($cache);
    }

    private static function _getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function get(string $key)
    {
        return self::_getInstance()->_cache->get($key);
    }

    public static function reset(string $key, mixed $value, int $expiration)
    {
        self::delete($key);
        return self::set($key, $value, $expiration);
    }

    public static function set(string $key, mixed $value, int $expiration)
    {
        return self::_getInstance()->_cache->set($key, $value, $expiration);
    }

    public static function delete(string|array $key)
    {
        return self::_getInstance()->_cache->delete($key);
    }

    public static function flush()
    {
        return self::_getInstance()->_cache->flush();
    }
}