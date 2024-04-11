<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'books';

    protected const TABLE_NAME = 'books';

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}