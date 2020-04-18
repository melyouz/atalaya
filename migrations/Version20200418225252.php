<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200418225252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_issue_code_excerpt_line (
          line INT NOT NULL,
          code_excerpt_id VARCHAR(36) NOT NULL,
          content VARCHAR(1024) NOT NULL,
          selected TINYINT(1) NOT NULL,
          INDEX IDX_D5BB6E05F21E989F (code_excerpt_id),
          PRIMARY KEY(code_excerpt_id, line)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_code_excerpt_line
        ADD
          CONSTRAINT FK_D5BB6E05F21E989F FOREIGN KEY (code_excerpt_id) REFERENCES app_issue_code_excerpt (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_issue_code_excerpt_line');
    }
}
