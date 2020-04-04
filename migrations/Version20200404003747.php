<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200404003747 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'add exception file excerpt lines';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          issue
        ADD
          exception_file_excerpt_lang VARCHAR(255) NOT NULL,
        ADD
          exception_file_excerpt_lines LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
        DROP
          exception_file_excerpt');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          issue
        ADD
          exception_file_excerpt VARCHAR(1024) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
        DROP
          exception_file_excerpt_lang,
        DROP
          exception_file_excerpt_lines');
    }
}
