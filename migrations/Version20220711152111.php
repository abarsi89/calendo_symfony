<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711152111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendor_address ADD vendor_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE vendor_address ADD CONSTRAINT FK_133957EEF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (vendor_id)');
        $this->addSql('CREATE INDEX IDX_133957EEF603EE73 ON vendor_address (vendor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendor_address DROP FOREIGN KEY FK_133957EEF603EE73');
        $this->addSql('DROP INDEX IDX_133957EEF603EE73 ON vendor_address');
        $this->addSql('ALTER TABLE vendor_address DROP vendor_id');
    }
}
