<?php

namespace App\Listener;

use App\Entity\Interfaces\CachedEntityInterface;
use App\Service\Cache\CacheHelper;
use EasyCorp\Bundle\EasyAdminBundle\Event\AbstractLifecycleEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

#[AsEventListener]
readonly class EntityCacheInvalidator implements EventSubscriberInterface
{
    public function __construct(private CacheHelper $cacheHelper) {}

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

        if ($entity instanceof CachedEntityInterface) {
            $this->cacheHelper->invalidateCache(
                $this->cacheHelper->calculateKey(
                    $entity->getCacheKey()
                )
            );
        }
    }
}