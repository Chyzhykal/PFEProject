<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115101317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE t_eventPriority (idPriority INT AUTO_INCREMENT NOT NULL, evepriname VARCHAR(100) NOT NULL, UNIQUE INDEX idPriority_UNIQUE (idPriority), PRIMARY KEY(idPriority)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE t_event ADD fkPriority INT DEFAULT NULL, DROP eveType');
        $this->addSql('ALTER TABLE t_event ADD CONSTRAINT FK_851F6CDE1FB76220 FOREIGN KEY (fkPriority) REFERENCES t_eventPriority (idPriority)');
        $this->addSql('CREATE INDEX fk_t_event_t_priority_idx ON t_event (fkPriority)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_event DROP FOREIGN KEY FK_851F6CDE1FB76220');
        $this->addSql('DROP TABLE t_eventPriority');
        $this->addSql('DROP INDEX fk_t_event_t_priority_idx ON t_event');
        $this->addSql('ALTER TABLE t_event ADD eveType VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, DROP fkPriority');
    }
}
