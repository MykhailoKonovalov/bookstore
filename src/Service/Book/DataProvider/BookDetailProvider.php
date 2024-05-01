<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BookDetailDTO;
use App\Entity\Book;
use App\Service\Book\DTOBuilder\BookDetailBuilder;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class BookDetailProvider
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private BookDetailBuilder $bookDetailBuilder,
    ) {}

    /**
     * @throws InvalidArgumentException
     */
    public function getCachedBook(Book $book): BookDetailDTO
    {
        $cacheBook = $this->cacheItemPool->getItem($book->getCacheKey());

        if (!$cacheBook->isHit()) {
            $bookDTO = $this->bookDetailBuilder->build($book);

            $this->cacheItemPool->save(
                $cacheBook
                    ->set($bookDTO)
                    ->expiresAfter(3600)
            );
        }

        return $cacheBook->get();
    }
}