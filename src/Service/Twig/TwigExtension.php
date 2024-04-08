<?php

namespace App\Service\Twig;

use App\Entity\User;
use App\Service\User\UserDataService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly UserDataService $userDataService,
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getUserName', [$this, 'getUserName']),
        ];
    }

    public function getUserName(): ?string
    {
        return $this->userDataService->getCurrentUser()?->getName();
    }
}