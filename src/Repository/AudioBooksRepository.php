<?php

namespace App\Repository;

use App\Entity\AudioBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AudioBook>
 *
 * @method AudioBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method AudioBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method AudioBook[]    findAll()
 * @method AudioBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AudioBooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AudioBook::class);
    }
}
