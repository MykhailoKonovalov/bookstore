<?php

namespace App\Service\Book\DTOBuilder;

use App\DTO\BooksListDTO;
use App\Entity\BookList;

readonly class BookListBuilder
{
    public function __construct(private BookPreviewBuilder $bookPreviewBuilder) {}

    public function build(BookList $bookList): BooksListDTO
    {
        $bookPreviewList = [];

        foreach ($bookList->getBooks() as $book) {
            $bookPreviewList[] = $this->bookPreviewBuilder->build($book);
        }

        return new BooksListDTO(
            $bookList->getTitle(),
            $bookPreviewList,
        );
    }
}