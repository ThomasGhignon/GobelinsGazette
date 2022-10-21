<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014131128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_parent_id INTEGER NOT NULL, comment_parent_id INTEGER DEFAULT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, likes INTEGER DEFAULT NULL, create_at DATETIME NOT NULL, delete_at DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_9474526CD314B487 FOREIGN KEY (post_parent_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C9B042B26 FOREIGN KEY (comment_parent_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9474526CD314B487 ON comment (post_parent_id)');
        $this->addSql('CREATE INDEX IDX_9474526C9B042B26 ON comment (comment_parent_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comment');
    }
}
