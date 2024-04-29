<?php

namespace App\Controller;

use App\Entity\Book;
use App\Service\Book\DataProvider\BookListProvider;
use App\Service\Book\DTOBuilder\BookDetailBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public const MAX_PER_PAGE = 12;

    public function __construct(
        private readonly BookDetailBuilder $bookDetailBuilder,
        private readonly BookListProvider $bookListProvider,
    ) {}

    #[Route('/book/{slug}', name: 'book_show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $this->bookDetailBuilder->build($book),
        ]);
    }

    #[Route('/discover', name: 'book_list')]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function list(
        Request $request,
        #[MapQueryParameter] int $page = 1,
    ): Response
    {
        return $this->render('discover/index.html.twig', [
            'books' => $this->bookListProvider->paginate(
                $request->query->getInt('page', $page),
            ),
        ]);
    }
}
