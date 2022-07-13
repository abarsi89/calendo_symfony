<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711152518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendor DROP primary_country, DROP primary_postalcode, DROP primary_city, DROP primary_address, DROP billing_country, DROP billing_postalcode, DROP billing_city, DROP billing_address');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendor ADD primary_country VARCHAR(255) NOT NULL, ADD primary_postalcode VARCHAR(255) NOT NULL, ADD primary_city VARCHAR(255) NOT NULL, ADD primary_address VARCHAR(255) NOT NULL, ADD billing_country VARCHAR(255) NOT NULL, ADD billing_postalcode VARCHAR(255) NOT NULL, ADD billing_city VARCHAR(255) NOT NULL, ADD billing_address VARCHAR(255) NOT NULL');
    }
}
