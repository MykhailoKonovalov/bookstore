<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411111008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add cover_url to books; Add stock_count to paper_books';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books ADD cover_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE paper_books ADD stock_count INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books DROP cover_url');
        $this->addSql('ALTER TABLE paper_books DROP stock_count');
    }
}
