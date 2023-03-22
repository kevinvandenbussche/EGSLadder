<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322150945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649676C7AF5');
        $this->addSql('DROP INDEX IDX_8D93D649676C7AF5 ON user');
        $this->addSql('ALTER TABLE user ADD received_id INT DEFAULT NULL, CHANGE messenger_id send_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913933E7B FOREIGN KEY (send_id) REFERENCES messenger (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B821E5F5 FOREIGN KEY (received_id) REFERENCES messenger (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64913933E7B ON user (send_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B821E5F5 ON user (received_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913933E7B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B821E5F5');
        $this->addSql('DROP INDEX IDX_8D93D64913933E7B ON user');
        $this->addSql('DROP INDEX IDX_8D93D649B821E5F5 ON user');
        $this->addSql('ALTER TABLE user ADD messenger_id INT DEFAULT NULL, DROP send_id, DROP received_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649676C7AF5 FOREIGN KEY (messenger_id) REFERENCES messenger (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649676C7AF5 ON user (messenger_id)');
    }
}
