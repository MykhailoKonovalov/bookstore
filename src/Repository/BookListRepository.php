<?php

namespace App\Repository;

use App\Entity\BookList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookList>
 *
 * @method BookList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookList[]    findAll()
 * @method BookList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookList::class);
    }
}
