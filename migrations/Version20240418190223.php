<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418190223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP CONSTRAINT fk_b3ba5a5a8100d06a');
        $this->addSql('DROP INDEX idx_b3ba5a5a8100d06a');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_BOOK_TYPE');
        $this->addSql('ALTER TABLE products RENAME COLUMN book_slug TO book_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A16A2B381 FOREIGN KEY (book_id) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A16A2B381 ON products (book_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_TYPE ON products (type, book_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A16A2B381');
        $this->addSql('DROP INDEX IDX_B3BA5A5A16A2B381');
        $this->addSql('DROP INDEX uniq_identifier_book_type');
        $this->addSql('ALTER TABLE products RENAME COLUMN book_id TO book_slug');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5a8100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b3ba5a5a8100d06a ON products (book_slug)');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_book_type ON products (type, book_slug)');
    }
}
