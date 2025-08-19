<?php

use Illuminate\Support\Facades\Redis;

class RedisCacheRepository implements CacheRepositoryInterface
{
    public function getKey(string $key): mixed
    {
        return Redis::get($key);
    }

    public function setKey(string $key, mixed $value, int $ttl): bool
    {
        return Redis::set($key, $value, 'NX', 'EX', $ttl);
    }

    public function incrementRateLimit(string $key): int {
        return Redis::incr($key);
    }

    public function getTtl(string $key): string {
        return Redis::ttl($key);
    }
}
