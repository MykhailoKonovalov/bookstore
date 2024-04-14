<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414115942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add main tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE ebook_formats_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_items_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reviews_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wish_lists_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE authors (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_AUTHOR_NAME ON authors (name)');
        $this->addSql('CREATE TABLE books (slug VARCHAR(255) NOT NULL, author_slug VARCHAR(255) NOT NULL, publisher_slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, translator VARCHAR(255) DEFAULT NULL, language VARCHAR(2) NOT NULL, cover_url VARCHAR(255) DEFAULT NULL, rating INT DEFAULT 0 NOT NULL, width NUMERIC(5, 2) NOT NULL, height NUMERIC(5, 2) NOT NULL, illustration BOOLEAN DEFAULT false NOT NULL, is_soft_cover BOOLEAN DEFAULT false NOT NULL, page_count INT NOT NULL, published_year INT NOT NULL, stock_count INT DEFAULT 0 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX IDX_4A1B2A9279844B35 ON books (publisher_slug)');
        $this->addSql('CREATE INDEX book_language_idx ON books (language)');
        $this->addSql('CREATE INDEX book_author_idx ON books (author_slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_TITLE ON books (title)');
        $this->addSql('CREATE TABLE categories_books (book_slug VARCHAR(255) NOT NULL, category_slug VARCHAR(255) NOT NULL, PRIMARY KEY(book_slug, category_slug))');
        $this->addSql('CREATE INDEX IDX_4E183FDF8100D06A ON categories_books (book_slug)');
        $this->addSql('CREATE INDEX IDX_4E183FDF1306E125 ON categories_books (category_slug)');
        $this->addSql('CREATE TABLE categories (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_CATEGORY_NAME ON categories (name)');
        $this->addSql('CREATE TABLE ebook_formats (id INT NOT NULL, product_uuid UUID NOT NULL, format VARCHAR(4) NOT NULL, file_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9E17B0A5C977207 ON ebook_formats (product_uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_FORMAT ON ebook_formats (format, product_uuid)');
        $this->addSql('COMMENT ON COLUMN ebook_formats.product_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE order_items (id INT NOT NULL, order_uuid UUID NOT NULL, product_uuid UUID NOT NULL, quantity INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX order_idx ON order_items (order_uuid)');
        $this->addSql('CREATE INDEX order_product_idx ON order_items (product_uuid)');
        $this->addSql('COMMENT ON COLUMN order_items.order_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN order_items.product_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE orders (uuid UUID NOT NULL, user_uuid UUID NOT NULL, total_price NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, status VARCHAR(32) DEFAULT \'started\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX order_user_idx ON orders (user_uuid)');
        $this->addSql('CREATE INDEX order_status_idx ON orders (status)');
        $this->addSql('COMMENT ON COLUMN orders.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN orders.user_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE products (uuid UUID NOT NULL, book_slug VARCHAR(255) NOT NULL, type VARCHAR(10) DEFAULT \'paper\' NOT NULL, price NUMERIC(8, 2) NOT NULL, discount_percent INT DEFAULT 0 NOT NULL, discount_price NUMERIC(8, 2) NOT NULL, sales_count INT DEFAULT 0 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A8100D06A ON products (book_slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_BOOK_TYPE ON products (type, book_slug)');
        $this->addSql('COMMENT ON COLUMN products.uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE publishers (slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_PUBLISHER_NAME ON publishers (name)');
        $this->addSql('CREATE TABLE reviews (id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, user_uuid UUID NOT NULL, rating INT DEFAULT 0 NOT NULL, text TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX review_book_idx ON reviews (book_slug)');
        $this->addSql('CREATE INDEX review_user_idx ON reviews (user_uuid)');
        $this->addSql('COMMENT ON COLUMN reviews.user_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE wish_lists (id INT NOT NULL, book_slug VARCHAR(255) NOT NULL, user_uuid UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AE8587038100D06A ON wish_lists (book_slug)');
        $this->addSql('CREATE INDEX IDX_AE858703ABFE1C6F ON wish_lists (user_uuid)');
        $this->addSql('COMMENT ON COLUMN wish_lists.user_uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A927C7213BD FOREIGN KEY (author_slug) REFERENCES authors (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9279844B35 FOREIGN KEY (publisher_slug) REFERENCES publishers (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories_books ADD CONSTRAINT FK_4E183FDF8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categories_books ADD CONSTRAINT FK_4E183FDF1306E125 FOREIGN KEY (category_slug) REFERENCES categories (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ebook_formats ADD CONSTRAINT FK_F9E17B0A5C977207 FOREIGN KEY (product_uuid) REFERENCES products (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB09C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES orders (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_items ADD CONSTRAINT FK_62809DB05C977207 FOREIGN KEY (product_uuid) REFERENCES products (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F8100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0FABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wish_lists ADD CONSTRAINT FK_AE8587038100D06A FOREIGN KEY (book_slug) REFERENCES books (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wish_lists ADD CONSTRAINT FK_AE858703ABFE1C6F FOREIGN KEY (user_uuid) REFERENCES users (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER INDEX idx_7ce748aa76ed395 RENAME TO rpr_user_idx');
        $this->addSql('ALTER TABLE users ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE users ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE users ALTER updated_at SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_PHONE ON users (phone)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE ebook_formats_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_items_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reviews_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wish_lists_id_seq CASCADE');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A927C7213BD');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A9279844B35');
        $this->addSql('ALTER TABLE categories_books DROP CONSTRAINT FK_4E183FDF8100D06A');
        $this->addSql('ALTER TABLE categories_books DROP CONSTRAINT FK_4E183FDF1306E125');
        $this->addSql('ALTER TABLE ebook_formats DROP CONSTRAINT FK_F9E17B0A5C977207');
        $this->addSql('ALTER TABLE order_items DROP CONSTRAINT FK_62809DB09C8E6AB1');
        $this->addSql('ALTER TABLE order_items DROP CONSTRAINT FK_62809DB05C977207');
        $this->addSql('ALTER TABLE orders DROP CONSTRAINT FK_E52FFDEEABFE1C6F');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A8100D06A');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0F8100D06A');
        $this->addSql('ALTER TABLE reviews DROP CONSTRAINT FK_6970EB0FABFE1C6F');
        $this->addSql('ALTER TABLE wish_lists DROP CONSTRAINT FK_AE8587038100D06A');
        $this->addSql('ALTER TABLE wish_lists DROP CONSTRAINT FK_AE858703ABFE1C6F');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE categories_books');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE ebook_formats');
        $this->addSql('DROP TABLE order_items');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE publishers');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE wish_lists');
        $this->addSql('ALTER INDEX rpr_user_idx RENAME TO idx_7ce748aa76ed395');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_PHONE');
        $this->addSql('ALTER TABLE users ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE users ALTER updated_at DROP NOT NULL');
    }
}
