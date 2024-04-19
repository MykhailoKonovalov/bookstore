<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookListFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'book_lists';

    protected const TABLE_NAME = 'book_lists';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}