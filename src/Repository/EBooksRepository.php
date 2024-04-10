<?php

namespace App\Repository;

use App\Entity\EBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EBook>
 *
 * @method EBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method EBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method EBook[]    findAll()
 * @method EBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EBooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EBook::class);
    }
}
