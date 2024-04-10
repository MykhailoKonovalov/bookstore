<?php

namespace App\Repository;

use App\Entity\PaperBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaperBook>
 *
 * @method PaperBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaperBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaperBook[]    findAll()
 * @method PaperBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaperBooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaperBook::class);
    }
}
