<?php

namespace App\Service\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class EntityHelper
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getRepository(string $className): EntityRepository
    {
        return $this->entityManager->getRepository($className);
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function deleteMany(array $objects): void
    {
        foreach ($objects as $object) {
            $this->entityManager->remove($object);
        }

        $this->entityManager->flush();
    }

    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(object $entity): void
    {
        $this->entityManager->flush($entity);
    }
}