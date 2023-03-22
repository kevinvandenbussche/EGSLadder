<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322163647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD send_id INT DEFAULT NULL, ADD receive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F13933E7B FOREIGN KEY (send_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4CB96DCC FOREIGN KEY (receive_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F13933E7B ON message (send_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F4CB96DCC ON message (receive_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649537A1329');
        $this->addSql('DROP INDEX IDX_8D93D649537A1329 ON user');
        $this->addSql('ALTER TABLE user DROP message_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F13933E7B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F4CB96DCC');
        $this->addSql('DROP INDEX IDX_B6BD307F13933E7B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F4CB96DCC ON message');
        $this->addSql('ALTER TABLE message DROP send_id, DROP receive_id');
        $this->addSql('ALTER TABLE user ADD message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649537A1329 ON user (message_id)');
    }
}
