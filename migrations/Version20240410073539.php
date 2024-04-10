<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410073539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tables: authors, categories, publishers, books, audio_books, ebooks, paper_books';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE audio_books (uuid UUID NOT NULL, book_slug VARCHAR(255) NOT NULL, duration_in_minutes INT NOT NULL, narrator VARCHAR(255) NOT NULL, file_url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX ab_book_idx ON audio_books (book_slug)');
        $this->addSql('COMMENT ON COLUMN audio_books.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE authors (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX author_name_idx ON authors (name)');
        $this->addSql('CREATE TABLE books (slug VARCHAR(255) NOT NULL, author_slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, translator VARCHAR(255) DEFAULT NULL, language VARCHAR(2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX book_title_idx ON books (title)');
        $this->addSql('CREATE INDEX book_language_idx ON books (language)');
        $this->addSql('CREATE INDEX book_author_idx ON books (author_slug)');
        $this->addSql('CREATE TABLE categories_books (book_slug VARCHAR(255) NOT NULL, category_slug VARCHAR(255) NOT NULL, PRIMARY KEY(book_slug, category_slug))');
        $this->addSql('CREATE INDEX IDX_4E183FDF8100D06A ON categories_books (book_slug)');
        $this->addSql('CREATE INDEX IDX_4E183FDF1306E125 ON categories_books (category_slug)');
        $this->addSql('CREATE TABLE categories (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX category_name_idx ON categories (name)');
        $this->addSql('CREATE TABLE ebooks (uuid UUID NOT NULL, book_slug VARCHAR(255) NOT NULL, format VARCHAR(5) NOT NULL, file_url VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price NUMERIC(8, 2) NOT NULL, discount_percent INT DEFAULT 0 NOT NULL, discount_price NUMERIC(8, 2) NOT NULL, sales_count INT DEFAULT 0 NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX eb_book_idx ON ebooks (book_slug)');
        $this->addSql('CREATE INDEX eb_format_idx ON ebooks (format)');
        $this->addSql('COMMENT ON COLUMN ebooks.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE paper_books (uuid UUID NOT NULL, book_slug VARCHAR(255) NOT NULL, publisher_slug VARCHAR(255) NOT NULL, width NUMERIC(5, 2) NOT NULL, height NUMERIC(5, 2) NOT NULL, illustration BOOLEAN DEFAULT false NOT NULL, is_soft_cover BOOLEAN DEFAULT false NOT NULL, page_count INT NOT NULL, published_year INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price NUMERIC(8, 2) NOT NULL, discount_percent INT DEFAULT 0 NOT NULL, discount_price NUMERIC(8, 2) NOT NULL, sales_count INT DEFAULT 0 NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX pb_book_idx ON paper_books (book_slug)');
        $this->addSql('CREATE INDEX pb_publisher_idx ON paper_books (publisher_slug)');
        $this->addSql('COMMENT ON COLUMN paper_books.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE publishers (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX publisher_name_idx ON publishers (name)');
        $this->addSql('ALTER TABLE audio_books ADD CONSTRAINT FK_288986518100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A927C7213BD FOREIGN KEY (author_slug) REFERENCES authors (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories_books ADD CONSTRAINT FK_4E183FDF8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories_books ADD CONSTRAINT FK_4E183FDF1306E125 FOREIGN KEY (category_slug) REFERENCES categories (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ebooks ADD CONSTRAINT FK_65C2E2C58100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT FK_C93E47F48100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT FK_C93E47F479844B35 FOREIGN KEY (publisher_slug) REFERENCES publishers (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX user_phone_idx ON users (phone)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT FK_288986518100D06A');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A927C7213BD');
        $this->addSql('ALTER TABLE categories_books DROP CONSTRAINT FK_4E183FDF8100D06A');
        $this->addSql('ALTER TABLE categories_books DROP CONSTRAINT FK_4E183FDF1306E125');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT FK_65C2E2C58100D06A');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT FK_C93E47F48100D06A');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT FK_C93E47F479844B35');
        $this->addSql('DROP TABLE audio_books');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE categories_books');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE ebooks');
        $this->addSql('DROP TABLE paper_books');
        $this->addSql('DROP TABLE publishers');
        $this->addSql('DROP INDEX user_phone_idx');
    }
}
