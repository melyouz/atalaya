<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200418225200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_issue_code_excerpt (
          id VARCHAR(36) NOT NULL,
          issue_id VARCHAR(36) NOT NULL,
          lang VARCHAR(255) NOT NULL,
          UNIQUE INDEX UNIQ_D7B4EA915E7AA58C (issue_id),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_code_excerpt
        ADD
          CONSTRAINT FK_D7B4EA915E7AA58C FOREIGN KEY (issue_id) REFERENCES app_issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_issue_file DROP excerpt_lang, DROP excerpt_lines');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_issue_code_excerpt');
        $this->addSql('ALTER TABLE
          app_issue_file
        ADD
          excerpt_lang VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        ADD
          excerpt_lines LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
