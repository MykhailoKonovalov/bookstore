<?php

namespace App\Listener;

use App\Entity\Interfaces\CachedEntityInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[AsEventListener]
readonly class EntityCacheInvalidator implements EventSubscriberInterface
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private LoggerInterface $logger,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => 'invalidateEntityCache',
            AfterEntityUpdatedEvent::class   => 'invalidateEntityCache',
            AfterEntityDeletedEvent::class   => 'invalidateEntityCache',
        ];
    }

    public function invalidateEntityCache(AbstractLifecycleEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof CachedEntityInterface) {
            return;
        }

        try {
            $this->cacheItemPool->deleteItem($entity->getCacheKey());
        } catch (InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}