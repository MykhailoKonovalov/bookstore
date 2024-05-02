<?php

namespace App\Service\Book\DataProvider;

use App\DTO\BookDetailDTO;
use App\Entity\Book;
use App\Exception\CacheNotFoundException;
use App\Service\Book\DTOBuilder\BookDetailBuilder;
use App\Service\Cache\CacheHelper;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

readonly class BookDetailProvider
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private CacheHelper $cacheHelper,
        private BookDetailBuilder $bookDetailBuilder,
    ) {}

    public function getCachedBook(Book $book): BookDetailDTO
    {
        $cacheBook = null;

        try {
            $cacheBook = $this->cacheItemPool->getItem(
                $this->cacheHelper->calculateKey($book->getCacheKey())
            );

            if (!$cacheBook->isHit()) {
                throw new CacheNotFoundException();
            }
        } catch (InvalidArgumentException|CacheNotFoundException) {
            $bookDTO = $this->bookDetailBuilder->build($book);

            $this->cacheItemPool->save(
                $cacheBook
                    ->set($bookDTO)
                    ->expiresAfter(3600)
            );
        } finally {
            return $cacheBook->get();
        }
    }
}