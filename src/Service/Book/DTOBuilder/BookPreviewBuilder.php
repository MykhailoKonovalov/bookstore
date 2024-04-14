<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BookPreviewDTO;
use App\Entity\Book;
use App\Entity\Interfaces\ProductInterface;
use App\Entity\Product;

class BookPreviewBuilder
{
    public function build(Book $book): BookPreviewDTO
    {
        $product = $this->findActualProduct($book);

        return new BookPreviewDTO(
            $book->getSlug(),
            $book->getTitle(),
            $book->getCoverUrl(),
            $book->getAuthor(),
            $product?->getPrice(),
            $product?->getDiscountPrice()
        );
    }

    private function findActualProduct(Book $book): ?Product
    {
        return $book->getStockCount() > 0
            ? $book->getPaperBook()
            : $book->getEBook();
    }
}