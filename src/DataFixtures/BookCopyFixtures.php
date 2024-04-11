<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookCopyFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'book_copies';

    protected const TABLE_NAME = 'book_copies';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}