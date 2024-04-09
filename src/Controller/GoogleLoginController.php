<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GoogleLoginController extends AbstractController
{
    private const GOOGLE_CLIENT = 'google';

    #[Route("/connect/google", name: "connect_google_start")]
    public function connectGoogleAction(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient(self::GOOGLE_CLIENT)
            ->redirect(
                [
                    'profile',
                    'email',
                ]
            );
    }

    #[Route("/connect/google/check", name: "connect_google_check")]
    public function connectGoogleCheckAction(): Response
    {
        return $this->redirectToRoute('home');
    }
}
