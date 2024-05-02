<?php

namespace App\Controller;

use App\DTO\WishListRequestDTO;
use App\Entity\Book;
use App\Entity\User;
use App\Service\WishList\WishListHelper;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class WishListController extends AbstractController
{
    public function __construct(
        private readonly WishListHelper $wishListHelper
    ) {}

    #[Route('/wishlist', name: 'wishlist')]
    public function list(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render(
            'profile/wishlist.html.twig', [
            'wishlist' => $this->wishListHelper->getWishListedBooksForUser($user),
        ]);
    }

    #[Route('/wishlist/add', name: 'wishlist_add', methods: ['POST'])]
    public function add(#[MapRequestPayload] WishListRequestDTO $wishListRequestDTO): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->getUser();

            $this->wishListHelper->create($wishListRequestDTO->bookSlug, $user);

            return new JsonResponse(['Element was successfully created!']);
        } catch (BadRequestException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode());
        }
    }

    #[Route('/wishlist/remove/{bookSlug}', name: 'wishlist_remove', methods: ['DELETE'])]
    public function remove(#[MapEntity(id: 'bookSlug')] Book $book): JsonResponse
    {
        try {
            /** @var User $user */
            $user = $this->getUser();

            $this->wishListHelper->remove($book, $user);

            return new JsonResponse(['Element was successfully deleted!']);
        } catch (BadRequestException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode());
        }
    }
}