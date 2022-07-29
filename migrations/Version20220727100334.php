<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727100334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_events (event_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', customer_email VARCHAR(255) DEFAULT NULL, INDEX IDX_5C60D9DA71F7E88B (event_id), INDEX IDX_5C60D9DAA76ED395 (user_id), PRIMARY KEY(event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_events ADD CONSTRAINT FK_5C60D9DA71F7E88B FOREIGN KEY (event_id) REFERENCES event (event_id)');
        $this->addSql('ALTER TABLE users_events ADD CONSTRAINT FK_5C60D9DAA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_events');
    }
}
