<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BookPreviewDTO;
use App\Entity\Book;
use App\Entity\Product;
use App\Service\Common\DTOValuesService;

class BookPreviewBuilder
{
    public function build(Book $book, ?Product $product = null): BookPreviewDTO
    {
        $product = $product ?: $this->findActualProduct($book);

        return new BookPreviewDTO(
            $book->getSlug(),
            $book->getTitle(),
            $book->getCoverUrl(),
            $book->getAuthor(),
            DTOValuesService::formatPriceValue($product?->getPrice()),
            $product?->getDiscountPercent()
                ? DTOValuesService::formatPriceValue($product->getDiscountPrice())
                : null,
            $product?->getDiscountPercent(),
            $product?->getType()
        );
    }

    private function findActualProduct(Book $book): ?Product
    {
        return $book->getStockCount() > 0
            ? $book->getPaperBook()
            : $book->getEBook();
    }
}