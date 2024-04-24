<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Throwable;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
final class EntityService
{
    private const MAX_RETRIES = 3;

    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function flush(): void
    {
        $this->em->flush();
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function getEntityManagerIfClosed(EntityManager $entityManager): EntityManager
    {
        return !$entityManager->isOpen()
            ? $entityManager::create($entityManager->getConnection(), $entityManager->getConfiguration())
            : $entityManager;
    }

    public function getRepository(string $entityName): EntityRepository
    {
        return $this->em->getRepository($entityName);
    }

    public function persist(object $entity): void
    {
        $this->em->persist($entity);
    }

    public function save(object $entity, bool $flush = true, bool $safeFlush = false): object
    {
        $this->em->persist($entity);
        if ($safeFlush) {
            $this->safeFlush($this->em);
        }

        if (!$safeFlush && $flush) {
            $this->flush();
        }

        return $entity;
    }

    private function safeFlush(?EntityManagerInterface $em = null): void
    {
        $em = $em ?? $this->em;
        $connection = $em->getConnection();
        $retryCount = 0;

        while ($retryCount < self::MAX_RETRIES) {
            try {
                /** @var EntityManager $em */
                $entityManager = $this->getEntityManagerIfClosed($em);
                $connection->beginTransaction();
                $entityManager->flush();
                $connection->commit();
                break;
            } catch (Throwable $exception) {
                $connection->rollBack();
                $retryCount++;
                if ($retryCount === self::MAX_RETRIES) {
                    throw $exception;
                }
            }
        }
    }
}
