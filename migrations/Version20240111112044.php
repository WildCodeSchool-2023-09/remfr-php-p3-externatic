<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111112044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criteria ADD name VARCHAR(255) DEFAULT NULL, ADD company_name VARCHAR(255) DEFAULT NULL, ADD contract_type INT DEFAULT NULL, CHANGE salary salary VARCHAR(255) NOT NULL, CHANGE profil profil VARCHAR(255) NOT NULL, CHANGE contract contract INT NOT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE remote remote INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE criteria DROP name, DROP company_name, DROP contract_type, CHANGE salary salary INT DEFAULT NULL, CHANGE profil profil VARCHAR(255) DEFAULT NULL, CHANGE contract contract INT DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE remote remote INT DEFAULT NULL');
    }
}
