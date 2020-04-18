<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200413003019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_issue_request (
          issue_id VARCHAR(36) NOT NULL,
          method VARCHAR(6) NOT NULL,
          url VARCHAR(255) NOT NULL,
          headers LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          PRIMARY KEY(issue_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_request
        ADD
          CONSTRAINT FK_412F7D25E7AA58C FOREIGN KEY (issue_id) REFERENCES app_issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_issue DROP request_method, DROP request_url, DROP request_headers');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_issue_request');
        $this->addSql('ALTER TABLE
          app_issue
        ADD
          request_method VARCHAR(6) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          request_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          request_headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
