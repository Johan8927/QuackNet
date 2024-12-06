<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241206085812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quack ADD COLUMN username VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_security AS SELECT id, email, roles, username, password FROM user_security');
        $this->addSql('DROP TABLE user_security');
        $this->addSql('CREATE TABLE user_security (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, email VARCHAR(180)DEFAULT NULL, roles CLOB DEFAULT NULL --(DC2Type:json)
        , username VARCHAR(180) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user_security (id, email, roles, username, password) SELECT id, email, roles, username, password FROM __temp__user_security');
        $this->addSql('DROP TABLE __temp__user_security');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_251631C1F85E0677 ON user_security (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user_security (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__quack AS SELECT id, author_id, content, created_at, updated_at, duckscreen, ducktag FROM quack');
        $this->addSql('DROP TABLE quack');
        $this->addSql('CREATE TABLE quack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, duckscreen VARCHAR(255) DEFAULT NULL, ducktag CLOB DEFAULT NULL, CONSTRAINT FK_83D44F6FF675F31B FOREIGN KEY (author_id) REFERENCES user_security (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quack (id, author_id, content, created_at, updated_at, duckscreen, ducktag) SELECT id, author_id, content, created_at, updated_at, duckscreen, ducktag FROM __temp__quack');
        $this->addSql('DROP TABLE __temp__quack');
        $this->addSql('CREATE INDEX IDX_83D44F6FF675F31B ON quack (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_security AS SELECT id, email, roles, username, password FROM user_security');
        $this->addSql('DROP TABLE user_security');
        $this->addSql('CREATE TABLE user_security (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , username VARCHAR(180) NOT NULL, password VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user_security (id, email, roles, username, password) SELECT id, email, roles, username, password FROM __temp__user_security');
        $this->addSql('DROP TABLE __temp__user_security');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_251631C1F85E0677 ON user_security (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user_security (email)');
    }
}
