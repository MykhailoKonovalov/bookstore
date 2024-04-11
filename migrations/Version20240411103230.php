<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411103230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Made timestamp columns not nullable';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE audio_books ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE audio_books ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE audio_books ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE authors ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE authors ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE authors ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE books ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE books ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE books ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE categories ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE categories ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE categories ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE ebooks ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE ebooks ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE ebooks ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE orders ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE orders ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE orders ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE paper_books ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE paper_books ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE paper_books ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE publishers ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE publishers ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE publishers ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE reviews ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE reviews ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE reviews ALTER updated_at SET NOT NULL');
        $this->addSql('DROP INDEX user_phone_idx');
        $this->addSql('ALTER TABLE users ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE users ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE users ALTER updated_at SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_PHONE ON users (phone)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE categories ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE categories ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE categories ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE books ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE books ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE books ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE authors ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE authors ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE authors ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE orders ALTER status TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE orders ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE orders ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE audio_books ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE audio_books ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE audio_books ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE reviews ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE reviews ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE reviews ALTER updated_at DROP NOT NULL');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_PHONE');
        $this->addSql('ALTER TABLE users ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER updated_at DROP NOT NULL');
        $this->addSql('CREATE INDEX user_phone_idx ON users (phone)');
        $this->addSql('ALTER TABLE publishers ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE publishers ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE publishers ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE paper_books ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE paper_books ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE paper_books ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE ebooks ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE ebooks ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE ebooks ALTER updated_at DROP NOT NULL');
    }
}
