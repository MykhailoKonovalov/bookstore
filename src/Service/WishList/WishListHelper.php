<?php

namespace App\Service\WishList;

use App\DTO\BookPreviewDTO;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\WishList;
use App\Exception\CacheNotFoundException;
use App\Repository\BookRepository;
use App\Repository\WishListRepository;
use App\Service\Book\DTOBuilder\BookPreviewBuilder;
use App\Service\Cache\CacheHelper;
use App\Service\Entity\EntityHelper;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

readonly class WishListHelper
{
    private const CACHE_PREFIX = 'wishList_';

    public function __construct(
        private EntityHelper $entityHelper,
        private CacheItemPoolInterface $cacheItemPool,
        private CacheHelper $cacheHelper,
        private BookRepository $bookRepository,
        private WishListRepository $wishListRepository,
    ) {}

    public function create(string $bookSlug, User $user): void
    {
        $book = $this->bookRepository->findOneBy(['slug' => $bookSlug]);

        if (!$book instanceof Book) {
            throw new BadRequestException('Book not found', Response::HTTP_NOT_FOUND);
        }

        $wishListedBook = new WishList();

        $wishListedBook
            ->setBookSlug($book)
            ->setUserUuid($user);

        try {
            $this->entityHelper->save($wishListedBook);
        } catch (Throwable $throwable) {
            throw new BadRequestException($throwable->getMessage(), 404);
        }

        $this->cacheHelper->invalidateCache(
            $this->cacheHelper->calculateKey(
                self::CACHE_PREFIX . $wishListedBook->getUserUuid()->getUuidAsString(),
            ),
        );
    }

    public function remove(Book $book, User $user): void
    {
        $wishListedBook = $this->wishListRepository
            ->findOneBy(['userUuid' => $user, 'bookSlug' => $book]);

        if (!$wishListedBook) {
            throw new BadRequestException('Element not found.', Response::HTTP_BAD_REQUEST);
        }

        $this->entityHelper->delete($wishListedBook);

        $this->cacheHelper->invalidateCache(
            $this->cacheHelper->calculateKey(
                self::CACHE_PREFIX . $wishListedBook->getUserUuid()->getUuidAsString(),
            ),
        );
    }

    public function getWishListedBooksForUser(User $user): array
    {
        $cacheBooks = null;
        try {
            $calculatedKey = $this->cacheHelper->calculateKey(self::CACHE_PREFIX . $user->getUuidAsString());
            $cacheBooks     = $this->cacheItemPool->getItem($calculatedKey);

            if (!$cacheBooks->isHit()) {
                throw new CacheNotFoundException();
            }
        } catch (InvalidArgumentException|CacheNotFoundException) {
            $wishListedBooks = $this->wishListRepository->findBy(['userUuid' => $user]);
            $bookData        = [];

            foreach ($wishListedBooks as $wishListedBook) {
                $bookData[] = BookPreviewBuilder::build($wishListedBook->getBookSlug());
            }

            $this->cacheItemPool->save(
                $cacheBooks
                    ->set($bookData)
                    ->expiresAfter(86400),
            );
        } finally {
            return $cacheBooks->get();
        }
    }

    public function isWishlisted(string $bookSlug, ?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        $wishListedBooks = $this->getWishListedBooksForUser($user);

        return (bool) array_filter(
            $wishListedBooks, function (BookPreviewDTO $bookPreview) use ($bookSlug) {
            return $bookPreview->slug === $bookSlug;
        });
    }
}