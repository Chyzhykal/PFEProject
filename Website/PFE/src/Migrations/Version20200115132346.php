<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115132346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_event DROP FOREIGN KEY fk_t_event_t_day1');
        $this->addSql('ALTER TABLE t_event ADD CONSTRAINT FK_851F6CDE1EDBB390 FOREIGN KEY (fkDay) REFERENCES t_day (idDay) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_event DROP FOREIGN KEY FK_851F6CDE1EDBB390');
        $this->addSql('ALTER TABLE t_event ADD CONSTRAINT fk_t_event_t_day1 FOREIGN KEY (fkDay) REFERENCES t_day (idDay) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
