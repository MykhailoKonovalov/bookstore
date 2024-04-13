<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ObjectManager;

abstract class MainAbstractFixture extends Fixture
{
    protected const FIXTURE_NAME = '';

    protected const TABLE_NAME = '';

    private const FIXTURES_PATH = 'src/DataFixtures/data/';

    public function __construct(private readonly Connection $connection) {}

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(self::FIXTURES_PATH . static::FIXTURE_NAME . '.json');
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $columns = $values = [];

            foreach ($item as $key => $value) {
                $columns[] = $key;
                $values[] = $this->connection->quote($value);
            }

            $query = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                static::TABLE_NAME,
                implode(', ', $columns),
                implode(', ', $values)
            );

            $this->connection->executeQuery($query);

            $this->additionalStep($this->connection, $item);
        }
    }

    protected function additionalStep(Connection $connection, array $item): void {}
}