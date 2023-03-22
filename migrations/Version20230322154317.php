<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322154317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64913933E7B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B821E5F5');
        $this->addSql('ALTER TABLE messenger DROP FOREIGN KEY FK_E22A4301727ACA70');
        $this->addSql('DROP TABLE messenger');
        $this->addSql('DROP INDEX IDX_8D93D64913933E7B ON user');
        $this->addSql('DROP INDEX IDX_8D93D649B821E5F5 ON user');
        $this->addSql('ALTER TABLE user DROP send_id, DROP received_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, text LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, time_stamp DATETIME NOT NULL, INDEX IDX_E22A4301727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A4301727ACA70 FOREIGN KEY (parent_id) REFERENCES messenger (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD send_id INT DEFAULT NULL, ADD received_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64913933E7B FOREIGN KEY (send_id) REFERENCES messenger (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B821E5F5 FOREIGN KEY (received_id) REFERENCES messenger (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D64913933E7B ON user (send_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B821E5F5 ON user (received_id)');
    }
}
