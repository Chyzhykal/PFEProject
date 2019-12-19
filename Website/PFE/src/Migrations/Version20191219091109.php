<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191219091109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_day CHANGE dayDate dayDate DATE NOT NULL, CHANGE dayBeginTime dayBeginTime TIME NOT NULL, CHANGE dayEndTime dayEndTime TIME NOT NULL');
        $this->addSql('ALTER TABLE t_event CHANGE eveTotPlaceNum eveTotPlaceNum INT NOT NULL, CHANGE evePlaceLeft evePlaceLeft INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_day CHANGE dayDate dayDate VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE dayBeginTime dayBeginTime VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE dayEndTime dayEndTime VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE t_event CHANGE eveTotPlaceNum eveTotPlaceNum NUMERIC(10, 0) NOT NULL, CHANGE evePlaceLeft evePlaceLeft NUMERIC(10, 0) NOT NULL');
    }
}
