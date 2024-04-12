<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412140135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set default value for order status';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders ALTER status SET DEFAULT \'started\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders ALTER status DROP DEFAULT');
    }
}
