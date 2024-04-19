<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419181549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compilations (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, priority INT NOT NULL, published BOOLEAN DEFAULT false NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_COMPILATION_PRIORITY ON compilations (priority)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_COMPILATION_NAME_PUB ON compilations (title, published)');
        $this->addSql('CREATE TABLE compilations_books (compilation_id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, PRIMARY KEY(compilation_id, book_slug))');
        $this->addSql('CREATE INDEX IDX_6580C751A5F8C840 ON compilations_books (compilation_id)');
        $this->addSql('CREATE INDEX IDX_6580C7518100D06A ON compilations_books (book_slug)');
        $this->addSql('ALTER TABLE compilations_books ADD CONSTRAINT FK_6580C751A5F8C840 FOREIGN KEY (compilation_id) REFERENCES compilations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE compilations_books ADD CONSTRAINT FK_6580C7518100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT fk_b3ba5a5a16a2b381');
        $this->addSql('DROP INDEX idx_b3ba5a5a16a2b381');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_BOOK_TYPE');
        $this->addSql('ALTER TABLE products RENAME COLUMN book_id TO book_slug');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A8100D06A ON products (book_slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_TYPE ON products (type, book_slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE compilations_books DROP CONSTRAINT FK_6580C751A5F8C840');
        $this->addSql('ALTER TABLE compilations_books DROP CONSTRAINT FK_6580C7518100D06A');
        $this->addSql('DROP TABLE compilations');
        $this->addSql('DROP TABLE compilations_books');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A8100D06A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A8100D06A');
        $this->addSql('DROP INDEX uniq_identifier_book_type');
        $this->addSql('ALTER TABLE products RENAME COLUMN book_slug TO book_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5a16a2b381 FOREIGN KEY (book_id) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b3ba5a5a16a2b381 ON products (book_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_book_type ON products (type, book_id)');
    }
}
