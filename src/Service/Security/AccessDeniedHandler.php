<?php

namespace App\Service\Security;

use App\Constant\UserRoles;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

readonly class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private Security $security,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?RedirectResponse
    {
        if (
            in_array(
                UserRoles::ROLE_ADMIN->value,
                $this->security->getUser()->getRoles()
            )
        ) {
            return null;
        }

        return new RedirectResponse($this->urlGenerator->generate('home'));
    }
}