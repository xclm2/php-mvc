<?php
namespace App\Framework\Cache\Service;

use App\Framework\Cache\CacheInterface;
use Memcached;

final class MemcachedService implements CacheInterface
{
    private const HOST = 'MEMCACHED_HOST';
    private const PORT = 'MEMCACHED_PORT';

    private $_connection;
    
    public function __construct()
    {
        $this->_connection = new Memcached();
        $this->_connection->addServer(env(self::HOST), env(self::PORT));    
    }

    public function get(string $key): mixed
    {
        return $this->_connection->get($key);
    }

    public function set(string $key, mixed $value, int $expiration): bool
    {
        return $this->_connection->set($key, $value, $expiration);
    }

    public function delete($key): bool
    {
        return $this->_connection->delete($key);
    }
    
    public function flush(): bool
    {
        return $this->_connection->flush();
    }

    public function __wakeup() {}
    public function __clone() {}
}