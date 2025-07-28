<?php

namespace App\Services;

class CustomCacheManager
{
    protected array $cache = [];

    public function set(string $key, mixed $value): void
    {
        $this->cache[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cache[$key] ?? $default;
    }

    public function forget(string $key): void
    {
        unset($this->cache[$key]);
    }

    public function clear(): void
    {
        $this->cache = [];
    }
}
