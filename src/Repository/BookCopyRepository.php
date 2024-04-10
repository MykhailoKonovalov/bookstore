<?php

namespace App\Repository;

use App\Entity\BookCopy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookCopy>
 *
 * @method BookCopy|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookCopy|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookCopy[]    findAll()
 * @method BookCopy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookCopyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookCopy::class);
    }
}
