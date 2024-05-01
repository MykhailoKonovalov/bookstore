<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\AuthorDTO;
use App\DTO\BookPreviewDTO;
use App\Entity\Book;
use App\Entity\Product;
use App\Service\Common\DTOValuesService;

class BookPreviewBuilder
{
    public static function build(Book $book, ?Product $product = null): BookPreviewDTO
    {
        $product = $product ?: (
            $book->getStockCount() > 0
                ? $book->getPaperBook()
                : $book->getEBook()
        );

        return new BookPreviewDTO(
            $book->getSlug(),
            $book->getTitle(),
            $book->getCoverUrl(),
            new AuthorDTO($book->getAuthor()->getSlug(), $book->getAuthor()->getName()),
            DTOValuesService::formatPriceValue($product?->getPrice()),
            $product?->getDiscountPercent()
                ? DTOValuesService::formatPriceValue($product->getDiscountPrice())
                : null,
            $product?->getDiscountPercent(),
            $product?->getType(),
        );
    }
}