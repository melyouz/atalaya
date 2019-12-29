<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191229160911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Update fields from datetime to datetime_immutable and from json to array accordingly';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          project CHANGE archived_at archived_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE
          issue CHANGE resolved_at resolved_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          CHANGE request_headers request_headers LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE
          issue CHANGE resolved_at resolved_at DATETIME DEFAULT NULL,
          CHANGE request_headers request_headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE project CHANGE archived_at archived_at DATETIME DEFAULT NULL');
    }
}
