<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BooksCompilationsFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'compilations_books';

    protected const TABLE_NAME = 'compilations_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
            CompilationFixtures::class,
        ];
    }
}