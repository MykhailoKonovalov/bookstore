<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'products';

    protected const TABLE_NAME = 'products';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}