<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\User;
use App\Service\Book\DataProvider\BookDetailProvider;
use App\Service\WishList\WishListHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(
        private readonly BookDetailProvider $bookDetailProvider,
        private readonly WishListHelper $wishListHelper,
    ) {}

    #[Route('/book/{type}/{slug}', name: 'book_show')]
    public function show(Book $book, string $type): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render(
            'book/show.html.twig', [
            'book'         => $this->bookDetailProvider->getCachedBook($book),
            'type'         => $type,
            'user'         => $user,
            'isWishlisted' => $this->wishListHelper->isWishlisted($book->getSlug(), $user),
        ]);
    }
}
