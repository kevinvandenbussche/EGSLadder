<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726153227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C4CAAD89F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494CAAD89F');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C85B3C07');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985B3C07');
        $this->addSql('CREATE TABLE calculation_elo (id INT AUTO_INCREMENT NOT NULL, division_game VARCHAR(255) NOT NULL, elo_internal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_play (id INT AUTO_INCREMENT NOT NULL, date_register_elo DATETIME NOT NULL, date_start DATETIME NOT NULL, date_end DATETIME DEFAULT NULL, elo INT NOT NULL, pseudonyme VARCHAR(255) NOT NULL, account_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE update_elo');
        $this->addSql('DROP TABLE user_in_game');
        $this->addSql('DROP INDEX IDX_232B318C4CAAD89F ON game');
        $this->addSql('DROP INDEX IDX_232B318C85B3C07 ON game');
        $this->addSql('ALTER TABLE game ADD to_play_id INT DEFAULT NULL, ADD calculation_id INT DEFAULT NULL, DROP user_in_game_id, DROP update_elo_id');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CABCF5048 FOREIGN KEY (to_play_id) REFERENCES to_play (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CCE3D4B33 FOREIGN KEY (calculation_id) REFERENCES calculation_elo (id)');
        $this->addSql('CREATE INDEX IDX_232B318CABCF5048 ON game (to_play_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CCE3D4B33 ON game (calculation_id)');
        $this->addSql('DROP INDEX IDX_8D93D6494CAAD89F ON user');
        $this->addSql('DROP INDEX IDX_8D93D64985B3C07 ON user');
        $this->addSql('ALTER TABLE user ADD to_play_id INT DEFAULT NULL, DROP update_elo_id, DROP user_in_game_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ABCF5048 FOREIGN KEY (to_play_id) REFERENCES to_play (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ABCF5048 ON user (to_play_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CCE3D4B33');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CABCF5048');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ABCF5048');
        $this->addSql('CREATE TABLE update_elo (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, elo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_in_game (id INT AUTO_INCREMENT NOT NULL, account VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_start DATETIME NOT NULL, date_end DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE calculation_elo');
        $this->addSql('DROP TABLE to_play');
        $this->addSql('DROP INDEX IDX_232B318CABCF5048 ON game');
        $this->addSql('DROP INDEX UNIQ_232B318CCE3D4B33 ON game');
        $this->addSql('ALTER TABLE game ADD user_in_game_id INT DEFAULT NULL, ADD update_elo_id INT DEFAULT NULL, DROP to_play_id, DROP calculation_id');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C85B3C07 FOREIGN KEY (user_in_game_id) REFERENCES user_in_game (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C4CAAD89F FOREIGN KEY (update_elo_id) REFERENCES update_elo (id)');
        $this->addSql('CREATE INDEX IDX_232B318C4CAAD89F ON game (update_elo_id)');
        $this->addSql('CREATE INDEX IDX_232B318C85B3C07 ON game (user_in_game_id)');
        $this->addSql('DROP INDEX IDX_8D93D649ABCF5048 ON user');
        $this->addSql('ALTER TABLE user ADD user_in_game_id INT DEFAULT NULL, CHANGE to_play_id update_elo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494CAAD89F FOREIGN KEY (update_elo_id) REFERENCES update_elo (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985B3C07 FOREIGN KEY (user_in_game_id) REFERENCES user_in_game (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494CAAD89F ON user (update_elo_id)');
        $this->addSql('CREATE INDEX IDX_8D93D64985B3C07 ON user (user_in_game_id)');
    }
}
