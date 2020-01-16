<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200116141436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE t_eventMerge (idMerge INT AUTO_INCREMENT NOT NULL, fkEvent1 INT DEFAULT NULL, fkEvent2 INT DEFAULT NULL, INDEX fk_t_eventMerge_t_event_id1 (fkEvent1), INDEX fk_t_eventMerge_t_event_id2 (fkEvent2), UNIQUE INDEX idmerge_UNIQUE (idMerge), PRIMARY KEY(idMerge)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE t_eventMerge ADD CONSTRAINT FK_3C13B99D872CBD29 FOREIGN KEY (fkEvent1) REFERENCES t_event (idEvent)');
        $this->addSql('ALTER TABLE t_eventMerge ADD CONSTRAINT FK_3C13B99D1E25EC93 FOREIGN KEY (fkEvent2) REFERENCES t_event (idEvent)');
        $this->addSql('ALTER TABLE t_event DROP FOREIGN KEY fk_t_event_t_event1');
        $this->addSql('DROP INDEX fk_t_event_t_event1 ON t_event');
        $this->addSql('ALTER TABLE t_event DROP fkLinkedEvent');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE t_eventMerge');
        $this->addSql('ALTER TABLE t_event ADD fkLinkedEvent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE t_event ADD CONSTRAINT fk_t_event_t_event1 FOREIGN KEY (fkLinkedEvent) REFERENCES t_event (idEvent) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX fk_t_event_t_event1 ON t_event (fkLinkedEvent)');
    }
}
