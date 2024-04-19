<?php

namespace App\Controller;

use App\Service\Book\DataProvider\BooksListProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly BooksListProvider $booksListProvider,
    ) {}

    #[Route('/', name: 'home')]
    #[Cache(expires: 3600, mustRevalidate: true)]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig', [
            'bookLists' => $this->booksListProvider->getBookLists(),
        ]);
    }
}
