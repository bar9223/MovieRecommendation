<?php

declare(strict_types=1);

namespace App\Modules\Core\Event\Listener;

use App\Modules\Core\Event\Subscriber\DeletedEntitySubscriber;
use App\Modules\Core\Event\Subscriber\DTO\DeletedEntityEventDTO;
use Doctrine\Common\Proxy\Proxy;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class EntityChangeListener
{
    //INFO: Classes are going to be sent with emit to Dash
    private const ENTITY_LISTEN_LIST = [
    ];

    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
    ) {
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->entityChanged($args, Events::postPersist);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->entityChanged($args, Events::postUpdate);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->entityChanged($args, Events::preRemove);

        $this->dispatcher->dispatch(
            new DeletedEntityEventDTO($args->getObject()),
            DeletedEntitySubscriber::EVENT_ENTITY_BEFORE_HARD_DELETE
        );
    }

    private function entityChanged(LifecycleEventArgs $args, string $eventName): void
    {
        $entity = $args->getObject();
        $entityClassName = $entity::class;
        if ($entity instanceof Proxy) {
            $entityClassName = ClassUtils::getClass($entity);
        }

        if (!in_array($entityClassName, self::ENTITY_LISTEN_LIST, true)) {
            return;
        }
    }
}
