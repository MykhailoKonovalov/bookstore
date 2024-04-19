<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BooksToListsFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'books_list_books';

    protected const TABLE_NAME = 'books_list_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
            BookListFixtures::class,
        ];
    }
}