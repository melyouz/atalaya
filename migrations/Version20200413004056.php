<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200413004056 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_issue_exception (
          issue_id VARCHAR(36) NOT NULL,
          code VARCHAR(255) NOT NULL,
          class VARCHAR(255) NOT NULL,
          message VARCHAR(255) NOT NULL,
          file_path VARCHAR(255) NOT NULL,
          file_line INT NOT NULL,
          file_excerpt_lang VARCHAR(255) NOT NULL,
          file_excerpt_lines LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          PRIMARY KEY(issue_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_exception
        ADD
          CONSTRAINT FK_64C079AE5E7AA58C FOREIGN KEY (issue_id) REFERENCES app_issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE
          app_issue
        DROP
          exception_code,
        DROP
          exception_class,
        DROP
          exception_message,
        DROP
          exception_file_path,
        DROP
          exception_file_line,
        DROP
          exception_file_excerpt_lang,
        DROP
          exception_file_excerpt_lines');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_issue_exception');
        $this->addSql('ALTER TABLE
          app_issue
        ADD
          exception_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          exception_class VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          exception_message VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          exception_file_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          exception_file_line INT NOT NULL,
        ADD
          exception_file_excerpt_lang VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          exception_file_excerpt_lines LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
