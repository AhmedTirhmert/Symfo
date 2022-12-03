<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221130084830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE football_stadiums');
        $this->addSql('DROP INDEX UNIQ_2D5B02345E237E06D8A48BBD ON city');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234D8A48BBD FOREIGN KEY (country_id_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234D8A48BBD ON city (country_id_id)');
        $this->addSql('ALTER TABLE team DROP INDEX IDX_C4E0A61FDCFF57F7, ADD UNIQUE INDEX UNIQ_C4E0A61FDCFF57F7 (stadium_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE football_stadiums (Confederation VARCHAR(8) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Stadium VARCHAR(39) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, City VARCHAR(24) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, HomeTeams VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Capacity INT DEFAULT NULL, Country VARCHAR(24) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, IOC VARCHAR(3) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, Population INT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234D8A48BBD');
        $this->addSql('DROP INDEX IDX_2D5B0234D8A48BBD ON city');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B02345E237E06D8A48BBD ON city (name, country_id_id)');
        $this->addSql('ALTER TABLE team DROP INDEX UNIQ_C4E0A61FDCFF57F7, ADD INDEX IDX_C4E0A61FDCFF57F7 (stadium_id_id)');
    }
}
