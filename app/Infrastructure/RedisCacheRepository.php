<?php

use Illuminate\Support\Facades\Redis;

class RedisCacheRepository implements CacheRepositoryInterface
{
    public function getKey(string $key): mixed
    {
        $data = Redis::get($key);

        if (!$data) return false;

        Redis::incr($key);

        return $data;
    }

    public function setKey(string $key, mixed $value, int $ttl): bool
    {
        return Redis::set($key, $value, 'NX', 'EX', $ttl);
    }
}
