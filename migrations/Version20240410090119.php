<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410090119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add new table: reviews';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE reviews_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reviews (id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, user_uuid UUID NOT NULL, rating INT DEFAULT 0 NOT NULL, text TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX review_book_idx ON reviews (book_slug)');
        $this->addSql('CREATE INDEX review_user_idx ON reviews (user_uuid)');
        $this->addSql('COMMENT ON COLUMN reviews.user_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD rating INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER INDEX idx_7ce748aa76ed395 RENAME TO rpr_user_idx');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE reviews_id_seq CASCADE');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0F8100D06A');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0FABFE1C6F');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('ALTER INDEX rpr_user_idx RENAME TO idx_7ce748aa76ed395');
        $this->addSql('ALTER TABLE books DROP rating');
    }
}
