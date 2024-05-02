<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501200646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique index for wish_lists table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_USER ON wish_lists (book_slug, user_uuid)');
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_BOOK_USER');
    }
}
