<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412125832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraint for name and title columns in authors, publishers, categories, books tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX author_name_idx');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_AUTHOR_NAME ON authors (name)');
        $this->addSql('DROP INDEX book_title_idx');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_TITLE ON books (title)');
        $this->addSql('DROP INDEX category_name_idx');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_CATEGORY_NAME ON categories (name)');
        $this->addSql('DROP INDEX publisher_name_idx');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_PUBLISHER_NAME ON publishers (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_BOOK_TITLE');
        $this->addSql('CREATE INDEX book_title_idx ON books (title)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_AUTHOR_NAME');
        $this->addSql('CREATE INDEX author_name_idx ON authors (name)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_PUBLISHER_NAME');
        $this->addSql('CREATE INDEX publisher_name_idx ON publishers (name)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_CATEGORY_NAME');
        $this->addSql('CREATE INDEX category_name_idx ON categories (name)');
    }
}
