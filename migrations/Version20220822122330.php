<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822122330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculation_elo ADD game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE calculation_elo ADD CONSTRAINT FK_71D2BC75E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_71D2BC75E48FD905 ON calculation_elo (game_id)');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CCE3D4B33');
        $this->addSql('DROP INDEX UNIQ_232B318CCE3D4B33 ON game');
        $this->addSql('ALTER TABLE game DROP calculation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calculation_elo DROP FOREIGN KEY FK_71D2BC75E48FD905');
        $this->addSql('DROP INDEX IDX_71D2BC75E48FD905 ON calculation_elo');
        $this->addSql('ALTER TABLE calculation_elo DROP game_id');
        $this->addSql('ALTER TABLE game ADD calculation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CCE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation_elo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CCE3D4B33 ON game (calculation_id)');
    }
}
