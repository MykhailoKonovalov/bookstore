<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\Book\DTOBuilder\BookDetailBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(private readonly BookDetailBuilder $bookDetailBuilder) {}

    #[Route('/book/{slug}', name: 'book_show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $this->bookDetailBuilder->build($book),
        ]);
    }
}
