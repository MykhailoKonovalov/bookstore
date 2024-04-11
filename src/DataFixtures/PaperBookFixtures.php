<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaperBookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'paper_books';

    protected const TABLE_NAME = 'paper_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}