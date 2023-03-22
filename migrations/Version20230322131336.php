<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322131336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger ADD parent_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger ADD CONSTRAINT FK_E22A4301B3750AF4 FOREIGN KEY (parent_id_id) REFERENCES messenger (id)');
        $this->addSql('CREATE INDEX IDX_E22A4301B3750AF4 ON messenger (parent_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger DROP FOREIGN KEY FK_E22A4301B3750AF4');
        $this->addSql('DROP INDEX IDX_E22A4301B3750AF4 ON messenger');
        $this->addSql('ALTER TABLE messenger DROP parent_id_id');
    }
}
