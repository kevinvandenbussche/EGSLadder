<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726095537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD user_in_game_id INT DEFAULT NULL, ADD update_elo_id INT DEFAULT NULL, ADD coach_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C85B3C07 FOREIGN KEY (user_in_game_id) REFERENCES user_in_game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C4CAAD89F FOREIGN KEY (update_elo_id) REFERENCES update_elo (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('CREATE INDEX IDX_232B318C85B3C07 ON game (user_in_game_id)');
        $this->addSql('CREATE INDEX IDX_232B318C4CAAD89F ON game (update_elo_id)');
        $this->addSql('CREATE INDEX IDX_232B318C3C105691 ON game (coach_id)');
        $this->addSql('ALTER TABLE user ADD update_elo_id INT DEFAULT NULL, ADD user_in_game_id INT DEFAULT NULL, DROP pseudonyme');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494CAAD89F FOREIGN KEY (update_elo_id) REFERENCES update_elo (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985B3C07 FOREIGN KEY (user_in_game_id) REFERENCES user_in_game (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494CAAD89F ON user (update_elo_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64985B3C07 ON user (user_in_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C85B3C07');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C4CAAD89F');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3C105691');
        $this->addSql('DROP INDEX IDX_232B318C85B3C07 ON game');
        $this->addSql('DROP INDEX IDX_232B318C4CAAD89F ON game');
        $this->addSql('DROP INDEX IDX_232B318C3C105691 ON game');
        $this->addSql('ALTER TABLE game DROP user_in_game_id, DROP update_elo_id, DROP coach_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494CAAD89F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985B3C07');
        $this->addSql('DROP INDEX IDX_8D93D6494CAAD89F ON user');
        $this->addSql('DROP INDEX IDX_8D93D64985B3C07 ON user');
        $this->addSql('ALTER TABLE user ADD pseudonyme VARCHAR(255) NOT NULL, DROP update_elo_id, DROP user_in_game_id');
    }
}
