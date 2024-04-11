<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AudioBookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'audio_books';

    protected const TABLE_NAME = 'audio_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }
}