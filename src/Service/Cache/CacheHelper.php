<?php

namespace App\Service\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;

readonly class CacheHelper
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private LoggerInterface $logger
    ) {}

    public function calculateKey(string $key): string
    {
        return sha1($key);
    }

    public function invalidateCache(string $key): void
    {
        try {
            $this->cacheItemPool->deleteItem($key);
        } catch (InvalidArgumentException $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}