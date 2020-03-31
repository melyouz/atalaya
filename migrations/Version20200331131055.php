<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200331131055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          issue
        ADD
          exception_code VARCHAR(255) NOT NULL,
        ADD
          exception_file_path VARCHAR(255) NOT NULL,
        ADD
          exception_file_line INT NOT NULL,
        ADD
          exception_file_excerpt VARCHAR(1024) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          issue
        DROP
          exception_code,
        DROP
          exception_file_path,
        DROP
          exception_file_line,
        DROP
          exception_file_excerpt');
    }
}
