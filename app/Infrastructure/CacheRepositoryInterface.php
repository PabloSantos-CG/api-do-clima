<?php

interface CacheRepositoryInterface
{
    public function getKey(string $key): mixed;
    public function setKey(string $key, mixed $value, int $ttl): bool;
    public function incrementRateLimit(string $key): int;
    public function getTtl(string $key): string;
}
