<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421184237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Made users softdeletable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ADD deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users DROP deleted_at');
    }
}
