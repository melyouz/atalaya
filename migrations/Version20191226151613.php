<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191226151613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag (
          name VARCHAR(255) NOT NULL,
          issue_id VARCHAR(36) NOT NULL,
          value VARCHAR(255) NOT NULL,
          INDEX IDX_389B7835E7AA58C (issue_id),
          PRIMARY KEY(issue_id, name)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue (
          id VARCHAR(36) NOT NULL,
          project_id VARCHAR(36) NOT NULL,
          resolved_at DATETIME DEFAULT NULL,
          request_method VARCHAR(6) NOT NULL,
          request_url VARCHAR(255) NOT NULL,
          request_headers LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\',
          exception_class VARCHAR(255) NOT NULL,
          exception_message VARCHAR(255) NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B7835E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7835E7AA58C');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE issue');
    }
}
