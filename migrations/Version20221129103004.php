<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129103004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country ADD population INT DEFAULT NULL, ADD area INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team DROP INDEX IDX_C4E0A61FDCFF57F7, ADD UNIQUE INDEX UNIQ_C4E0A61FDCFF57F7 (stadium_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP population, DROP area');
        $this->addSql('ALTER TABLE team DROP INDEX UNIQ_C4E0A61FDCFF57F7, ADD INDEX IDX_C4E0A61FDCFF57F7 (stadium_id_id)');
    }
}
