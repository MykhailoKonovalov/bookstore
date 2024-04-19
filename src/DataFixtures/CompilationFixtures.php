<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompilationFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'compilations';

    protected const TABLE_NAME = 'compilations';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}