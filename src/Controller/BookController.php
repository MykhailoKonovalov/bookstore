<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\Book\DataProvider\BookDetailProvider;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(private readonly BookDetailProvider $bookDetailProvider) {}

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/book/{type}/{slug}', name: 'book_show')]
    public function show(Book $book, string $type): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $this->bookDetailProvider->getCachedBook($book),
            'type' => $type,
        ]);
    }
}
