<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class AudioBookFixtures extends MainAbstractFixture implements DependentFixtureInterface
{
    protected const FIXTURE_NAME = 'audio_books';

    protected const TABLE_NAME   = 'audio_books';

    public function getDependencies(): array
    {
        return [
            BookFixtures::class,
        ];
    }

    /**
     * @throws Exception
     */
    protected function additionalStep(Connection $connection, array $item): void
    {
        $query     = "UPDATE books SET audio_book_uuid = :uuid WHERE slug = :slug";
        $statement = $connection->prepare($query);

        $statement->bindValue('uuid', $item['uuid']);
        $statement->bindValue('slug', $item['book_slug']);
        $statement->executeQuery();
    }
}