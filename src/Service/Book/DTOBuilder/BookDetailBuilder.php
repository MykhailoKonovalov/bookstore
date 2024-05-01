<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\AuthorDTO;
use App\DTO\BookDetailDTO;
use App\DTO\CategoryDTO;
use App\DTO\PublisherDTO;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Product;

readonly class BookDetailBuilder
{
    public function __construct(private ProductBuilder $productBuilder) {}

    public function build(Book $book): BookDetailDTO
    {
        return new BookDetailDTO(
            $book->getSlug(),
            $book->getTitle(),
            new AuthorDTO($book->getAuthor()->getSlug(), $book->getAuthor()->getName()),
            new PublisherDTO($book->getPublisher()->getSlug(), $book->getPublisher()->getName()),
            array_map(
                fn (Category $category) => new CategoryDTO($category->getSlug(), $category->getName()),
                $book->getCategory()->toArray()
            ),
            $book->getLanguage(),
            $book->getPublishedYear(),
            $book->getPageCount(),
            $book->getDescription(),
            $book->getCoverUrl(),
            $book->isIllustration(),
            $book->isSoftCover(),
            $book->getTranslator(),
            $book->getWidth(),
            $book->getHeight(),
            $book->getStockCount(),
            array_map(
                fn(Product $product) => $this->productBuilder->build($product),
                $book->getProducts()->toArray()
            )
        );
    }
}