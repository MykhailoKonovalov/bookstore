<?php

namespace App\Service\Book\DataProvider;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Service\Book\DTOBuilder\BookPreviewBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

readonly class BookListProvider
{
    public const PER_PAGE = 12;

    public function __construct(
        private BookRepository $bookRepository,
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
        $books = $this->bookRepository
            ->getBooksForPagination();

        return iterator_to_array($this->buildBookPreviewList($books));
    }

    /**
     * @param Book[] $books
     */
    public function buildBookPreviewList(array $books): iterable
    {
        foreach ($books as $book) {
            yield $this->bookPreviewBuilder->build($book);
        }
    }
}