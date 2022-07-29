<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713140253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD service_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ADD vendor_address_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (service_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76FC27B12 FOREIGN KEY (vendor_address_id) REFERENCES vendor_address (vendor_address_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7ED5CA9E6 ON event (service_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA76FC27B12 ON event (vendor_address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7ED5CA9E6');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76FC27B12');
        $this->addSql('DROP INDEX IDX_3BAE0AA7ED5CA9E6 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA76FC27B12 ON event');
        $this->addSql('ALTER TABLE event DROP service_id, DROP vendor_address_id');
    }
}
