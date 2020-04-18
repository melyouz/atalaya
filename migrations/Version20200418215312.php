<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200418215312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_issue_file (
          issue_id VARCHAR(36) NOT NULL,
          path VARCHAR(255) NOT NULL,
          line INT NOT NULL,
          excerpt_lang VARCHAR(255) NOT NULL,
          excerpt_lines LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          PRIMARY KEY(issue_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_file
        ADD
          CONSTRAINT FK_826355A05E7AA58C FOREIGN KEY (issue_id) REFERENCES app_issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          app_issue_exception
        DROP
          file_path,
        DROP
          file_line,
        DROP
          file_excerpt_lang,
        DROP
          file_excerpt_lines');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_issue_file');
        $this->addSql('ALTER TABLE
          app_issue_exception
        ADD
          file_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          file_line INT NOT NULL,
        ADD
          file_excerpt_lang VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          file_excerpt_lines LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
