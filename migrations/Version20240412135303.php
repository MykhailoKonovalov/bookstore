<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412135303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'O - optimization';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE book_copies ALTER type TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE ebooks ALTER format TYPE VARCHAR(4)');
        $this->addSql('ALTER TABLE orders ALTER status TYPE VARCHAR(32)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE book_copies ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE ebooks ALTER format TYPE VARCHAR(255)');
    }
}
