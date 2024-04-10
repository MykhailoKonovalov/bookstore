<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240410135613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tables: orders, order_items and wish_lists';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wish_list_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE order_item (id INT NOT NULL, order_uuid UUID NOT NULL, book_copy_uuid UUID NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F099C8E6AB1 ON order_item (order_uuid)');
        $this->addSql('CREATE INDEX IDX_52EA1F0912BF561C ON order_item (book_copy_uuid)');
        $this->addSql('COMMENT ON COLUMN order_item.order_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN order_item.book_copy_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE orders (uuid UUID NOT NULL, user_id UUID NOT NULL, total_price NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, status VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_E52FFDEEA76ED395 ON orders (user_id)');
        $this->addSql('COMMENT ON COLUMN orders.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE wish_list (id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, user_uuid UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5B8739BD8100D06A ON wish_list (book_slug)');
        $this->addSql('CREATE INDEX IDX_5B8739BDABFE1C6F ON wish_list (user_uuid)');
        $this->addSql('COMMENT ON COLUMN wish_list.user_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F099C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES orders (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0912BF561C FOREIGN KEY (book_copy_uuid) REFERENCES book_copies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wish_list ADD CONSTRAINT FK_5B8739BD8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wish_list ADD CONSTRAINT FK_5B8739BDABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE order_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wish_list_id_seq CASCADE');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F099C8E6AB1');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F0912BF561C');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE wish_list DROP CONSTRAINT FK_5B8739BD8100D06A');
        $this->addSql('ALTER TABLE wish_list DROP CONSTRAINT FK_5B8739BDABFE1C6F');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE wish_list');
    }
}
