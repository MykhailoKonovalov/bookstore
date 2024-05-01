<?php

namespace App\Service\Discover;

use App\Service\Book\DTOBuilder\BookPreviewBuilder;
use Pagerfanta\Adapter\AdapterInterface;

final readonly class ProductDTOPaginationAdapter implements AdapterInterface
{
    public function __construct(private AdapterInterface $decoratedAdapter) {}

    public function getNbResults(): int
    {
        return $this->decoratedAdapter->getNbResults();
    }

    public function getSlice(int $offset, int $length): iterable
    {
        $rawData = $this->decoratedAdapter->getSlice($offset, $length);

        foreach ($rawData as $product) {
            yield BookPreviewBuilder::build($product->getBook(), $product);
        }
    }
}