<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207101445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE football_stadiums');
        $this->addSql('DROP TABLE worldcities');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234D8A48BBD');
        $this->addSql('ALTER TABLE city ADD latitude NUMERIC(10, 10) DEFAULT NULL, ADD longitude NUMERIC(10, 10) DEFAULT NULL, ADD population INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234D8A48BBD FOREIGN KEY (country_id_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY country_ibfk_1');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3EB4C3185E237E06 ON league (name)');
        $this->addSql('DROP INDEX city_id_id ON stadium');
        $this->addSql('ALTER TABLE team DROP INDEX IDX_C4E0A61FDCFF57F7, ADD UNIQUE INDEX UNIQ_C4E0A61FDCFF57F7 (stadium_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE football_stadiums (id INT AUTO_INCREMENT NOT NULL, Confederation VARCHAR(8) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Stadium VARCHAR(39) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, City VARCHAR(24) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, HomeTeams VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Capacity INT DEFAULT NULL, Country VARCHAR(24) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, IOC VARCHAR(3) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Population INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE worldcities (city VARCHAR(49) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, city_ascii VARCHAR(49) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, lat NUMERIC(7, 4) DEFAULT NULL, lng NUMERIC(8, 4) DEFAULT NULL, country VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, iso2 VARCHAR(2) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, iso3 VARCHAR(3) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, admin_name VARCHAR(53) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, capital VARCHAR(7) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, population VARCHAR(8) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, id INT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234D8A48BBD');
        $this->addSql('ALTER TABLE city DROP latitude, DROP longitude, DROP population');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234D8A48BBD FOREIGN KEY (country_id_id) REFERENCES country (id) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('DROP INDEX UNIQ_3EB4C3185E237E06 ON league');
        $this->addSql('CREATE UNIQUE INDEX city_id_id ON stadium (city_id_id, name)');
        $this->addSql('ALTER TABLE team DROP INDEX UNIQ_C4E0A61FDCFF57F7, ADD INDEX IDX_C4E0A61FDCFF57F7 (stadium_id_id)');
    }
}
