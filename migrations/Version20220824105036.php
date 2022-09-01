<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824105036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE login (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', password VARCHAR(255) NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_events DROP customer_email, CHANGE user_id user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ADD PRIMARY KEY (event_id, user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE login');
        $this->addSql('ALTER TABLE users_events DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE users_events ADD customer_email VARCHAR(255) DEFAULT NULL, CHANGE user_id user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
    }
}
