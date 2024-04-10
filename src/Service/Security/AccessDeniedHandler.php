<?php

namespace App\Service\Security;

use App\Constant\UserRoles;
use App\Service\User\UserDataService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

readonly class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UserDataService $userDataService,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        if (
            !in_array(
                UserRoles::ROLE_ADMIN->value,
                $this->userDataService->getCurrentUser()->getRoles()
            )
        ) {
            return new RedirectResponse($this->urlGenerator->generate('home'));
        }

        return null;
    }
}