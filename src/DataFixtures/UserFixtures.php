<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setName('Admin User')
            ->setEmail('admin@admin.com')
            ->setPhone('+380123456789')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setPassword(password_hash('admin2281488', PASSWORD_DEFAULT));

        $manager->persist($user);
        $manager->flush();
    }
}