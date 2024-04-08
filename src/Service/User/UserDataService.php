<?php

namespace App\Service\User;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

readonly class UserDataService
{
    public function __construct(private Security $security) {}

    public function getCurrentUser(): ?User
    {
        /** @var User|null */
        return $this->security->getUser();
    }
}