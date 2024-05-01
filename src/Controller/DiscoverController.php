<?php

namespace App\Controller;

use App\Service\Book\DataProvider\ProductListProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DiscoverController extends AbstractController
{
    public function __construct(private readonly ProductListProvider $productListProvider) {}

    #[Route('/discover', name: 'discover')]
    public function list(Request $request): Response
    {
        return $this->render('discover/index.html.twig', [
            'books' => $this->productListProvider->paginate($request->query->all()),
        ]);
    }
}