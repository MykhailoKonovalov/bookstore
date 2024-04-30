<?php

namespace App\Service\Book\DataProvider;

use App\Entity\Book;
use App\Entity\Product;
use App\Repository\BookRepository;
use App\Repository\ProductRepository;
use App\Service\Book\DTOBuilder\BookPreviewBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

readonly class ProductListProvider
{
    public const PER_PAGE = 12;

    public function __construct(
        private ProductRepository $productRepository,
        private BookPreviewBuilder $bookPreviewBuilder,
        private PaginatorInterface $paginator,
    ) {}

    public function paginate(
        int $page,
    ): PaginationInterface {
        return $this->paginator
            ->paginate(
                $this->getBooks(),
                $page,
                self::PER_PAGE
            );
    }

    private function getBooks(): array
    {
        $products = $this->productRepository
            ->getProductsForPagination();

        return iterator_to_array($this->buildProductPreviewList($products));
    }

    /**
     * @param Product[] $products
     */
    public function buildProductPreviewList(array $products): iterable
    {
        foreach ($products as $product) {
            yield $this->bookPreviewBuilder->build($product->getBook(), $product);
        }
    }
}