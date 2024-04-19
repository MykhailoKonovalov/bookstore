<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BooksListDTO;
use App\Repository\BookListRepository;
use App\Service\Book\DTOBuilder\BookListBuilder;

readonly class BooksListProvider
{
    public function __construct(
        private BookListRepository $bookListRepository,
        private BookListBuilder $bookListBuilder,
    ) {}

    /**
     * @return BooksListDTO[]
     */
    public function getBookLists(): array
    {
        $bookLists    = $this->bookListRepository->findBy(
            [
                'published' => true,
            ], ['priority' => 'ASC']);
        $bookListDTOs = [];

        foreach ($bookLists as $bookList) {
            $bookListDTOs[] = $this->bookListBuilder->build($bookList);
        }

        return $bookListDTOs;
    }
}