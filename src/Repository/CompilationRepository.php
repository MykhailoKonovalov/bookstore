<?php

namespace App\Repository;

use App\Entity\Compilation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Compilation>
 *
 * @method Compilation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compilation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compilation[]    findAll()
 * @method Compilation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompilationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compilation::class);
    }
}
