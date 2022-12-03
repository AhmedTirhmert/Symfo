<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129095708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('DROP TABLE test_entity');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B02345E237E06D8A48BBD ON city (name, country_id_id)');
        // $this->addSql('ALTER TABLE country ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C96698260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_5373C96698260155 ON country (region_id)');
        $this->addSql('DROP INDEX uniq_5373c966ce3e7619 ON country');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C9665E237E06 ON country (name)');
        $this->addSql('ALTER TABLE team DROP INDEX IDX_C4E0A61FDCFF57F7, ADD UNIQUE INDEX UNIQ_C4E0A61FDCFF57F7 (stadium_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C96698260155');
        $this->addSql('CREATE TABLE test_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP INDEX UNIQ_2D5B02345E237E06D8A48BBD ON city');
        $this->addSql('DROP INDEX IDX_5373C96698260155 ON country');
        $this->addSql('ALTER TABLE country DROP region_id');
        $this->addSql('DROP INDEX uniq_5373c9665e237e06 ON country');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5373C966CE3E7619 ON country (name)');
        $this->addSql('ALTER TABLE team DROP INDEX UNIQ_C4E0A61FDCFF57F7, ADD INDEX IDX_C4E0A61FDCFF57F7 (stadium_id_id)');
    }
}
