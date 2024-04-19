<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419074910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create book_lists table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE book_lists (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, priority INT NOT NULL, published BOOLEAN DEFAULT false NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_LIST_PRIORITY ON book_lists (priority)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_LIST_NAME_PUB ON book_lists (title, published)');
        $this->addSql('CREATE TABLE books_list_books (book_list_id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, PRIMARY KEY(book_list_id, book_slug))');
        $this->addSql('CREATE INDEX IDX_BF0F97ECAE8E3E1D ON books_list_books (book_list_id)');
        $this->addSql('CREATE INDEX IDX_BF0F97EC8100D06A ON books_list_books (book_slug)');
        $this->addSql('ALTER TABLE books_list_books ADD CONSTRAINT FK_BF0F97ECAE8E3E1D FOREIGN KEY (book_list_id) REFERENCES book_lists (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books_list_books ADD CONSTRAINT FK_BF0F97EC8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE books_list_books DROP CONSTRAINT FK_BF0F97ECAE8E3E1D');
        $this->addSql('ALTER TABLE books_list_books DROP CONSTRAINT FK_BF0F97EC8100D06A');
        $this->addSql('DROP TABLE book_lists');
        $this->addSql('DROP TABLE books_list_books');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A8100D06A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A8100D06A');
        $this->addSql('DROP INDEX uniq_identifier_book_type');
        $this->addSql('ALTER TABLE products RENAME COLUMN book_slug TO book_id');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT fk_b3ba5a5a16a2b381 FOREIGN KEY (book_id) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b3ba5a5a16a2b381 ON products (book_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_book_type ON products (type, book_id)');
    }
}
