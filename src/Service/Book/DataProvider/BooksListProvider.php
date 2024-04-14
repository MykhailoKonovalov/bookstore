<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BooksListDTO;
use App\Repository\BookRepository;
use App\Service\Book\DTOBuilder\BookPreviewBuilder;

class BooksListProvider
{
    public const NEW_BOOKS_LIST_NAME = 'Новинки';

    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly BookPreviewBuilder $bookPreviewBuilder,
    ) {}

    public function getLatestBooksList(): BooksListDTO
    {
        $books = $this->bookRepository->findLatest();
        $booksList = [];

        foreach ($books as $book) {
            $booksList[] = $this->bookPreviewBuilder->build($book);
        }

        return new BooksListDTO(
            self::NEW_BOOKS_LIST_NAME,
            0,
            $booksList
        );
    }
}