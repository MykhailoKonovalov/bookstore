<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryBookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'categories_books';

    protected const TABLE_NAME = 'categories_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
            CategoryFixtures::class,
        ];
    }
}