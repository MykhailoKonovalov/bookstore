<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EBookFormatFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'ebook_formats';

    protected const TABLE_NAME = 'ebook_formats';

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
        ];
    }
}