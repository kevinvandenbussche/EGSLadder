<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727133540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CABCF5048');
        $this->addSql('DROP INDEX IDX_232B318CABCF5048 ON game');
        $this->addSql('ALTER TABLE game DROP to_play_id');
        $this->addSql('ALTER TABLE to_play ADD user_id INT DEFAULT NULL, ADD game_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE to_play ADD CONSTRAINT FK_B967CF75A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE to_play ADD CONSTRAINT FK_B967CF75E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_B967CF75A76ED395 ON to_play (user_id)');
        $this->addSql('CREATE INDEX IDX_B967CF75E48FD905 ON to_play (game_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ABCF5048');
        $this->addSql('DROP INDEX IDX_8D93D649ABCF5048 ON user');
        $this->addSql('ALTER TABLE user DROP to_play_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD to_play_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CABCF5048 FOREIGN KEY (to_play_id) REFERENCES to_play (id)');
        $this->addSql('CREATE INDEX IDX_232B318CABCF5048 ON game (to_play_id)');
        $this->addSql('ALTER TABLE to_play DROP FOREIGN KEY FK_B967CF75A76ED395');
        $this->addSql('ALTER TABLE to_play DROP FOREIGN KEY FK_B967CF75E48FD905');
        $this->addSql('DROP INDEX IDX_B967CF75A76ED395 ON to_play');
        $this->addSql('DROP INDEX IDX_B967CF75E48FD905 ON to_play');
        $this->addSql('ALTER TABLE to_play DROP user_id, DROP game_id');
        $this->addSql('ALTER TABLE user ADD to_play_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ABCF5048 FOREIGN KEY (to_play_id) REFERENCES to_play (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ABCF5048 ON user (to_play_id)');
    }
}
