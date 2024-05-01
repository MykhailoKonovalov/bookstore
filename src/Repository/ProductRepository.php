<?php

namespace App\Repository;

use App\Entity\Product;
use ArrayIterator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function createProductsQueryBuilder(
        string $sortBy,
        string $sortDirection,
        array $filters = []
    ): QueryBuilder {
        $qb = $this
            ->createQueryBuilder('p')
            ->leftJoin('p.book', 'b')
            ->leftJoin('b.category', 'c');

        foreach ($filters as $field => $value) {
            match ($field) {
                'type'      => $qb
                    ->andWhere($qb->expr()->eq('p.type', ':type'))
                    ->setParameter('type', $value),
                'author'    => $qb
                    ->andWhere($qb->expr()->eq('b.author', ':author'))
                    ->setParameter('author', $value),
                'publisher' => $qb
                    ->andWhere($qb->expr()->eq('b.publisher', ':publisher'))
                    ->setParameter('publisher', $value),
                'category'  => $qb
                    ->andWhere($qb->expr()->eq('c.slug', ':category'))
                    ->setParameter('category', $value),
                default     => null,
            };
        }

        return $qb->orderBy($sortBy, $sortDirection);
    }
}
