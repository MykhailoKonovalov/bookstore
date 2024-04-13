<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413183740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add two-way cascading deletion for relations between books and ebooks, paper_books, audio_books';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT FK_288986518100D06A');
        $this->addSql('ALTER TABLE audio_books ADD CONSTRAINT FK_288986518100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A92AE2E97F');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A929CB316AE');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A92FAAFA842');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92AE2E97F FOREIGN KEY (paper_book_uuid) REFERENCES paper_books (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A929CB316AE FOREIGN KEY (audio_book_uuid) REFERENCES audio_books (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92FAAFA842 FOREIGN KEY (ebook_uuid) REFERENCES ebooks (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT FK_65C2E2C58100D06A');
        $this->addSql('ALTER TABLE ebooks ADD CONSTRAINT FK_65C2E2C58100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT FK_C93E47F48100D06A');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT FK_C93E47F48100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE paper_books DROP CONSTRAINT fk_c93e47f48100d06a');
        $this->addSql('ALTER TABLE paper_books ADD CONSTRAINT fk_c93e47f48100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE audio_books DROP CONSTRAINT fk_288986518100d06a');
        $this->addSql('ALTER TABLE audio_books ADD CONSTRAINT fk_288986518100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT fk_4a1b2a92ae2e97f');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT fk_4a1b2a929cb316ae');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT fk_4a1b2a92faafa842');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT fk_4a1b2a92ae2e97f FOREIGN KEY (paper_book_uuid) REFERENCES paper_books (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT fk_4a1b2a929cb316ae FOREIGN KEY (audio_book_uuid) REFERENCES audio_books (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT fk_4a1b2a92faafa842 FOREIGN KEY (ebook_uuid) REFERENCES ebooks (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ebooks DROP CONSTRAINT fk_65c2e2c58100d06a');
        $this->addSql('ALTER TABLE ebooks ADD CONSTRAINT fk_65c2e2c58100d06a FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
