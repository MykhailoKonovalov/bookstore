<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EBookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'ebooks';

    protected const TABLE_NAME = 'ebooks';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}