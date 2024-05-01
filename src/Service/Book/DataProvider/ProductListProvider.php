<?php

namespace App\Service\Book\DataProvider;

use App\Constant\FilteredColumns;
use App\Repository\ProductRepository;
use App\Service\Discover\ProductDTOPaginationAdapter;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

readonly class ProductListProvider
{
    public const PER_PAGE = 12;

    public function __construct(private ProductRepository $productRepository) {}

    public function paginate(array $queryParams): Pagerfanta
    {
        $page           = $queryParams['page'] ?? 1;
        $sortBy         = $queryParams['sortBy'] ?? 'p.createdAt';
        $sortDirection  = $queryParams['sortDirection'] ?? 'DESC';
        $filters        = array_filter(
            $queryParams,
            fn($key) => in_array($key, FilteredColumns::COLUMNS, true),
            ARRAY_FILTER_USE_KEY,
        );
        $queryBuilder   = $this->productRepository->createProductsQueryBuilder($sortBy, $sortDirection, $filters);
        $queryAdapter   = new QueryAdapter($queryBuilder);
        $productAdapter = new ProductDTOPaginationAdapter($queryAdapter);
        $paginator      = new Pagerfanta($productAdapter);

        return $paginator
            ->setMaxPerPage(self::PER_PAGE)
            ->setCurrentPage($page);
    }
}