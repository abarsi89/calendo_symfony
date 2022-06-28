<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624154814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (role_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_roles (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', role_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_51498A8EA76ED395 (user_id), INDEX IDX_51498A8ED60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_vendors (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', vendor_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_BF25CEDBA76ED395 (user_id), INDEX IDX_BF25CEDBF603EE73 (vendor_id), PRIMARY KEY(user_id, vendor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (vendor_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, primary_country VARCHAR(255) NOT NULL, primary_postalcode VARCHAR(255) NOT NULL, primary_city VARCHAR(255) NOT NULL, primary_address VARCHAR(255) NOT NULL, billing_country VARCHAR(255) NOT NULL, billing_postalcode VARCHAR(255) NOT NULL, billing_city VARCHAR(255) NOT NULL, billing_address VARCHAR(255) NOT NULL, vat_number VARCHAR(255) NOT NULL, bank_account_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(vendor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8EA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE users_roles ADD CONSTRAINT FK_51498A8ED60322AC FOREIGN KEY (role_id) REFERENCES role (role_id)');
        $this->addSql('ALTER TABLE users_vendors ADD CONSTRAINT FK_BF25CEDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (user_id)');
        $this->addSql('ALTER TABLE users_vendors ADD CONSTRAINT FK_BF25CEDBF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (vendor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_roles DROP FOREIGN KEY FK_51498A8ED60322AC');
        $this->addSql('ALTER TABLE users_roles DROP FOREIGN KEY FK_51498A8EA76ED395');
        $this->addSql('ALTER TABLE users_vendors DROP FOREIGN KEY FK_BF25CEDBA76ED395');
        $this->addSql('ALTER TABLE users_vendors DROP FOREIGN KEY FK_BF25CEDBF603EE73');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE users_roles');
        $this->addSql('DROP TABLE users_vendors');
        $this->addSql('DROP TABLE vendor');
    }
}
