<?php

namespace App\Controller;

use App\Service\Book\DataProvider\BookCompilationProvider;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly BookCompilationProvider $bookCompilationProvider) {}

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/', name: 'home')]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function index(): Response
    {
        return $this->render(
            'home/index.html.twig', [
            'compilations' => $this->bookCompilationProvider->getBookCompilations(),
        ]);
    }
}
