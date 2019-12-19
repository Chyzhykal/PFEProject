<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191219085732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_day CHANGE dayDate dayDate VARCHAR(45) NOT NULL, CHANGE dayBeginTime dayBeginTime VARCHAR(45) NOT NULL, CHANGE dayEndTime dayEndTime VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE t_event CHANGE eveTotPlaceNum eveTotPlaceNum NUMERIC(10, 0) NOT NULL, CHANGE evePlaceLeft evePlaceLeft NUMERIC(10, 0) NOT NULL, CHANGE fkUser fkUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE t_event_has_t_participant RENAME INDEX fk_t_event_has_t_participant_t_event_idx TO IDX_39CA754C2B748B86');
        $this->addSql('ALTER TABLE t_event_has_t_participant RENAME INDEX fk_t_event_has_t_participant_t_participant1_idx TO IDX_39CA754CC226DE2D');
        $this->addSql('ALTER TABLE t_participant DROP parCode, CHANGE parRole parRole VARCHAR(45) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_day CHANGE dayDate dayDate DATE NOT NULL, CHANGE dayBeginTime dayBeginTime TIME NOT NULL, CHANGE dayEndTime dayEndTime TIME NOT NULL');
        $this->addSql('ALTER TABLE t_event CHANGE eveTotPlaceNum eveTotPlaceNum INT NOT NULL, CHANGE evePlaceLeft evePlaceLeft INT NOT NULL, CHANGE fkUser fkUser INT NOT NULL');
        $this->addSql('ALTER TABLE t_event_has_t_participant RENAME INDEX idx_39ca754c2b748b86 TO fk_t_event_has_t_participant_t_event_idx');
        $this->addSql('ALTER TABLE t_event_has_t_participant RENAME INDEX idx_39ca754cc226de2d TO fk_t_event_has_t_participant_t_participant1_idx');
        $this->addSql('ALTER TABLE t_participant ADD parCode INT NOT NULL, CHANGE parRole parRole VARCHAR(45) CHARACTER SET utf8 DEFAULT \'Standard\' COLLATE `utf8_general_ci`');
    }
}
