<?php

namespace App\Listener;

use App\Entity\Interfaces\CachedEntityInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

#[AsEntityListener]
readonly class EntityChangeSubscriber implements EventSubscriber
{
    public function __construct(private CacheItemPoolInterface $cacheItemPool) {}

    public function getSubscribedEvents(): array
    {
        return [
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function postUpdate(CachedEntityInterface $entity): void
    {
        $this->invalidateCache($entity);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function postRemove(CachedEntityInterface $entity): void
    {
        $this->invalidateCache($entity);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function invalidateCache(CachedEntityInterface $entity): void
    {
        $this->cacheItemPool->deleteItem($entity->getCacheKey());
    }
}