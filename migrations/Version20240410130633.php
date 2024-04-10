<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410130633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add book_copies table to connect main book entity and book types';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE book_copies (uuid UUID NOT NULL, book_slug VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX book_copies_books_idx ON book_copies (book_slug)');
        $this->addSql('CREATE INDEX book_copies_type_idx ON book_copies (type)');
        $this->addSql('COMMENT ON COLUMN book_copies.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE book_copies ADD CONSTRAINT FK_F0A8D8118100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT fk_288986518100d06a');
        $this->addSql('DROP INDEX ab_book_idx');
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT audio_books_pkey');
        $this->addSql('ALTER TABLE audio_books ADD price NUMERIC(8, 2) NOT NULL');
        $this->addSql('ALTER TABLE audio_books ADD discount_percent INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE audio_books ADD discount_price NUMERIC(8, 2) NOT NULL');
        $this->addSql('ALTER TABLE audio_books ADD sales_count INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE audio_books DROP book_slug');
        $this->addSql('ALTER TABLE audio_books RENAME COLUMN uuid TO book_copy_uuid');
        $this->addSql('ALTER TABLE audio_books ADD CONSTRAINT FK_2889865112BF561C FOREIGN KEY (book_copy_uuid) REFERENCES book_copies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE audio_books ADD PRIMARY KEY (book_copy_uuid)');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT fk_65c2e2c58100d06a');
        $this->addSql('DROP INDEX eb_book_idx');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT ebooks_pkey');
        $this->addSql('ALTER TABLE ebooks DROP book_slug');
        $this->addSql('ALTER TABLE ebooks ALTER format TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE ebooks RENAME COLUMN uuid TO book_copy_uuid');
        $this->addSql('ALTER TABLE ebooks ADD CONSTRAINT FK_65C2E2C512BF561C FOREIGN KEY (book_copy_uuid) REFERENCES book_copies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ebooks ADD PRIMARY KEY (book_copy_uuid)');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT fk_c93e47f48100d06a');
        $this->addSql('DROP INDEX pb_book_idx');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT paper_books_pkey');
        $this->addSql('ALTER TABLE paper_books DROP book_slug');
        $this->addSql('ALTER TABLE paper_books RENAME COLUMN uuid TO book_copy_uuid');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT FK_C93E47F412BF561C FOREIGN KEY (book_copy_uuid) REFERENCES book_copies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paper_books ADD PRIMARY KEY (book_copy_uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT FK_2889865112BF561C');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT FK_65C2E2C512BF561C');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT FK_C93E47F412BF561C');
        $this->addSql('ALTER TABLE book_copies DROP CONSTRAINT FK_F0A8D8118100D06A');
        $this->addSql('DROP TABLE book_copies');
        $this->addSql('DROP INDEX paper_books_pkey');
        $this->addSql('ALTER TABLE paper_books ADD book_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE paper_books RENAME COLUMN book_copy_uuid TO uuid');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT fk_c93e47f48100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX pb_book_idx ON paper_books (book_slug)');
        $this->addSql('ALTER TABLE paper_books ADD PRIMARY KEY (uuid)');
        $this->addSql('DROP INDEX audio_books_pkey');
        $this->addSql('ALTER TABLE audio_books ADD book_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE audio_books DROP price');
        $this->addSql('ALTER TABLE audio_books DROP discount_percent');
        $this->addSql('ALTER TABLE audio_books DROP discount_price');
        $this->addSql('ALTER TABLE audio_books DROP sales_count');
        $this->addSql('ALTER TABLE audio_books RENAME COLUMN book_copy_uuid TO uuid');
        $this->addSql('ALTER TABLE audio_books ADD CONSTRAINT fk_288986518100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX ab_book_idx ON audio_books (book_slug)');
        $this->addSql('ALTER TABLE audio_books ADD PRIMARY KEY (uuid)');
        $this->addSql('DROP INDEX ebooks_pkey');
        $this->addSql('ALTER TABLE ebooks ADD book_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ebooks ALTER format TYPE VARCHAR(5)');
        $this->addSql('ALTER TABLE ebooks RENAME COLUMN book_copy_uuid TO uuid');
        $this->addSql('ALTER TABLE ebooks ADD CONSTRAINT fk_65c2e2c58100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX eb_book_idx ON ebooks (book_slug)');
        $this->addSql('ALTER TABLE ebooks ADD PRIMARY KEY (uuid)');
    }
}
