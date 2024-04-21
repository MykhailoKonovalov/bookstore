<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240420172122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sticker_color column in compilations table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE compilations ADD sticker_color VARCHAR(7) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE compilations DROP sticker_color');
    }
}
