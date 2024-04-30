<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\PublisherRepository;
use App\Service\Book\DataProvider\ProductListProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class DiscoverController extends AbstractController
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly PublisherRepository $publisherRepository,
        private readonly ProductListProvider $productListProvider,
    ) {}

    #[Route('/discover', name: 'discover')]
    public function list(
        #[MapQueryParameter] int $page = 1,
    ): Response {
        return $this->render('discover/index.html.twig', [
            'books' => $this->productListProvider->paginate(
                $page,
            ),
        ]);
    }

    #[Route('/discover/authors', name: 'discover_authors')]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function getAuthors(): Response
    {
        return $this->render('discover/authors.html.twig', [
            'authors' => $this->authorRepository->findAll(),
        ]);
    }

    #[Route('/discover/categories', name: 'discover_categories')]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function getCategories(): Response
    {
        return $this->render('discover/categories.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/discover/publishers', name: 'discover_publishers')]
    #[Cache(expires: 3600, public: true, mustRevalidate: true)]
    public function getPublishers(): Response
    {
        return $this->render('discover/publishers.html.twig', [
            'publishers' => $this->publisherRepository->findAll(),
        ]);
    }
}