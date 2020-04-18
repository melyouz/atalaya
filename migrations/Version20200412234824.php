<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200412234824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B7835E7AA58C');
        $this->addSql('CREATE TABLE app_project (
          id VARCHAR(36) NOT NULL,
          name VARCHAR(80) NOT NULL,
          url VARCHAR(80) NOT NULL,
          token VARCHAR(32) NOT NULL,
          platform VARCHAR(30) NOT NULL,
          archived_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          user_id VARCHAR(36) NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_issue_tag (
          name VARCHAR(255) NOT NULL,
          issue_id VARCHAR(36) NOT NULL,
          value VARCHAR(255) NOT NULL,
          INDEX IDX_2462358B5E7AA58C (issue_id),
          PRIMARY KEY(issue_id, name)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_issue (
          id VARCHAR(36) NOT NULL,
          project_id VARCHAR(36) NOT NULL,
          seen_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          resolved_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          request_method VARCHAR(6) NOT NULL,
          request_url VARCHAR(255) NOT NULL,
          request_headers LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          exception_code VARCHAR(255) NOT NULL,
          exception_class VARCHAR(255) NOT NULL,
          exception_message VARCHAR(255) NOT NULL,
          exception_file_path VARCHAR(255) NOT NULL,
          exception_file_line INT NOT NULL,
          exception_file_excerpt_lang VARCHAR(255) NOT NULL,
          exception_file_excerpt_lines LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_user (
          id VARCHAR(36) NOT NULL,
          name VARCHAR(255) NOT NULL,
          email VARCHAR(255) NOT NULL,
          password VARCHAR(255) NOT NULL,
          roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
          disabled_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          confirmation_token VARCHAR(255) DEFAULT NULL,
          UNIQUE INDEX UNIQ_88BDF3E9E7927C74 (email),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE
          app_issue_tag
        ADD
          CONSTRAINT FK_2462358B5E7AA58C FOREIGN KEY (issue_id) REFERENCES app_issue (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_issue_tag DROP FOREIGN KEY FK_2462358B5E7AA58C');
        $this->addSql('CREATE TABLE issue (
          id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          project_id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          resolved_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          request_method VARCHAR(6) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          request_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          request_headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\',
          exception_class VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          exception_message VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          seen_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          exception_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          exception_file_path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          exception_file_line INT NOT NULL,
          exception_file_excerpt_lang VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          exception_file_excerpt_lines LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\',
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\'');
        $this->addSql('CREATE TABLE project (
          id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          name VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          url VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          archived_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          user_id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          token VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          platform VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\'');
        $this->addSql('CREATE TABLE tag (
          name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          issue_id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          INDEX IDX_389B7835E7AA58C (issue_id),
          PRIMARY KEY(issue_id, name)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\'');
        $this->addSql('CREATE TABLE user (
          id VARCHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
          roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\',
          disabled_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
          confirmation_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`,
          UNIQUE INDEX UNIQ_8D93D649E7927C74 (email),
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\'');
        $this->addSql('ALTER TABLE
          tag
        ADD
          CONSTRAINT FK_389B7835E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE app_project');
        $this->addSql('DROP TABLE app_issue_tag');
        $this->addSql('DROP TABLE app_issue');
        $this->addSql('DROP TABLE app_user');
    }
}
