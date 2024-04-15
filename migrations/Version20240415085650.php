<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415085650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update some columns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A927C7213BD');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A9279844B35');
        $this->addSql('ALTER TABLE books ALTER author_slug DROP NOT NULL');
        $this->addSql('ALTER TABLE books ALTER publisher_slug DROP NOT NULL');
        $this->addSql('ALTER TABLE books ALTER language TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A927C7213BD FOREIGN KEY (author_slug) REFERENCES authors (slug) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9279844B35 FOREIGN KEY (publisher_slug) REFERENCES publishers (slug) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ALTER price TYPE INT');
        $this->addSql('ALTER TABLE products ALTER discount_price TYPE INT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products ALTER price TYPE NUMERIC(8, 2)');
        $this->addSql('ALTER TABLE products ALTER discount_price TYPE NUMERIC(8, 2)');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT fk_4a1b2a927c7213bd');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT fk_4a1b2a9279844b35');
        $this->addSql('ALTER TABLE books ALTER author_slug SET NOT NULL');
        $this->addSql('ALTER TABLE books ALTER publisher_slug SET NOT NULL');
        $this->addSql('ALTER TABLE books ALTER language TYPE VARCHAR(2)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT fk_4a1b2a927c7213bd FOREIGN KEY (author_slug) REFERENCES authors (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT fk_4a1b2a9279844b35 FOREIGN KEY (publisher_slug) REFERENCES publishers (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
